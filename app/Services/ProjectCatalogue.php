<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class ProjectCatalogue
{
    public function categories(): Collection
    {
        return collect(config('projects.categories', []));
    }

    /** Return lightweight project metadata for listings and navigation. */
    public function all(): Collection
    {
        return collect(config('projects.projects', []))
            ->map(function (array $project, string $slug) {
                $project['slug'] = $slug;
                $project['url'] = route('oolalabs.projects.show', ['slug' => $slug]);
                return $project;
            })
            ->filter(fn (array $project) => (bool) ($project['published'] ?? true))
            ->sortBy([['order', 'asc'], ['title', 'asc']])
            ->values();
    }

    public function find(string $slug): array
    {
        abort_unless(preg_match('/^[A-Za-z0-9_-]+$/', $slug), 404);

        $projects = config('projects.projects', []);
        abort_unless(isset($projects[$slug]), 404);

        $project = $projects[$slug];
        abort_unless((bool) ($project['published'] ?? true), 404);

        $relativePath = $project['content_path'] ?? '';
        $relativePath = preg_replace('#^content/#', '', $relativePath);

        $path = resource_path('views/content/' . $relativePath);

        if ($path !== null) {
            $document = File::get($path);
            [, $markdown] = $this->parseDocument($document);
        } else {
            $markdown = '# ' . $project['title'] . "\n\n"
                . ($project['summary'] ?? 'Project overview and proposed engineering scope.')
                . "\n\n## Proposed scope\n\nThe detailed project brief is being prepared. Use the catalogue summary as the initial scope and refine requirements, milestones, architecture, testing and deployment during project planning.";
        }

        $project['slug'] = $slug;
        $project['markdown'] = $markdown;
        $project['content'] = $this->renderMarkdown($markdown);
        $project['url'] = route('oolalabs.projects.show', ['slug' => $slug]);
        $project['sidebar'] = $this->buildSidebar($project, $markdown);

        return $project;
    }

    /** Resolve both the original resources/content path and the existing views/content layout. */
    private function resolveContentPath(string $configuredPath): ?string
    {
        $relative = ltrim(str_replace(['\\', '../'], ['/', ''], $configuredPath), '/');
        if ($relative === '') {
            return null;
        }

        $candidates = [
            resource_path($relative),
            resource_path('views/' . $relative),
        ];

        // Current project Markdown files are stored under resources/views/content/projects/.
        if (str_starts_with($relative, 'content/')) {
            $candidates[] = resource_path('views/' . $relative);
        }

        foreach (array_unique($candidates) as $candidate) {
            if (File::isFile($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private function buildSidebar(array $project, string $markdown): array
    {
        $scope = $this->section($markdown, '/^##\s+(?:Proposed scope(?: and core capabilities)?|Scope and core capabilities)\s*$/mi');
        $architecture = $this->section($markdown, '/^##\s+Suggested architecture and technology\s*$/mi');
        $users = $this->section($markdown, '/^##\s+Business problem and users\s*$/mi');
        $milestones = $this->section($markdown, '/^##\s+Suggested milestones\s*$/mi');
        $deliverables = $this->section($markdown, '/^##\s+Expected deliverables\s*$/mi');
        $quality = $this->section($markdown, '/^##\s+(?:Security, privacy and quality|Testing and acceptance criteria)\s*$/mi');

        $modules = $this->listItems($scope, 6);
        $technology = $this->listItems($architecture, 4);
        $roadmap = $this->listItems($milestones, 7);
        $outputs = $this->listItems($deliverables, 6);

        return [
            'domain' => $project['category'] ?? 'OolaLabs project',
            'status' => $project['status'] ?? 'Proposed project',
            'users' => $this->plainText($users, 240) ?: 'Confirm the primary user roles and their responsibilities during project discovery.',
            'modules' => $modules ?: ['Core business workflow', 'User and role management', 'Reporting and administration'],
            'technology' => $technology ?: ['Frontend interface', 'Backend API and business logic', 'Relational database', 'Automated testing and deployment'],
            'quality' => $this->plainText($quality, 260) ?: 'Validate business rules, access control, error handling and important user journeys with automated tests.',
            'roadmap' => $roadmap ?: [
                'Discovery and scope',
                'Architecture and data model',
                'Core workflow implementation',
                'Integration and testing',
                'Deployment and demonstration',
            ],
            'deliverables' => $outputs ?: ['Source code and README', 'Data model and API documentation', 'Automated tests', 'Deployment and demonstration notes'],
        ];
    }

    private function section(string $markdown, string $headingPattern): string
    {
        $lines = preg_split('/\R/', $markdown);
        $capturing = false;
        $sectionLines = [];

        foreach ($lines as $line) {
            if (!$capturing) {
                if (preg_match($headingPattern, trim($line))) {
                    $capturing = true;
                }
                continue;
            }

            if (preg_match('/^#{1,2}\s+/', trim($line))) {
                break;
            }

            $sectionLines[] = $line;
        }

        return trim(implode("\n", $sectionLines));
    }

    private function listItems(string $section, int $limit): array
    {
        if ($section === '') {
            return [];
        }

        $items = [];
        foreach (preg_split('/\R/', $section) as $line) {
            $line = trim($line);
            if (preg_match('/^(?:[-*+]\s+|\d+[.)]\s+)(.+)$/', $line, $match)) {
                $item = $this->plainText($match[1], 150);
                if ($item !== '') {
                    $items[] = $item;
                }
            }
            if (count($items) >= $limit) {
                break;
            }
        }

        return $items;
    }

    private function plainText(string $text, int $limit): string
    {
        $text = preg_replace('/^#{1,6}\s+/m', '', $text);
        $text = preg_replace('/\*\*(.*?)\*\*/s', '$1', $text);
        $text = preg_replace('/\*(.*?)\*/s', '$1', $text);
        $text = preg_replace('/`([^`]*)`/', '$1', $text);
        $text = preg_replace('/\[([^\]]+)\]\([^)]+\)/', '$1', $text);
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text, " \t\n\r\0\x0B-:;,.→");

        if (mb_strlen($text) > $limit) {
            $text = rtrim(mb_substr($text, 0, $limit - 1)) . '…';
        }

        return $text;
    }

    public function renderMarkdown(string $markdown): string
    {
        return (string) (new GithubFlavoredMarkdownConverter())->convert($markdown);
    }

    private function parseDocument(string $document): array
    {
        if (!preg_match('/\A---\s*\R(.*?)\R---\s*\R?(.*)\z/s', $document, $matches)) {
            return [[], $document];
        }

        $metadata = [];
        foreach (preg_split('/\R/', $matches[1]) as $line) {
            if (preg_match('/^\s*([A-Za-z0-9_-]+)\s*:\s*(.*?)\s*$/', $line, $pair)) {
                $value = trim($pair[2]);
                if (strlen($value) >= 2 && (($value[0] === '"' && str_ends_with($value, '"')) || ($value[0] === "'" && str_ends_with($value, "'")))) {
                    $value = substr($value, 1, -1);
                }
                $metadata[$pair[1]] = $value;
            }
        }

        return [$metadata, $matches[2]];
    }
}

