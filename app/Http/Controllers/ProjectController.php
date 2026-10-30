<?php

namespace App\Http\Controllers;

use App\Services\ProjectCatalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(Request $request, ProjectCatalogue $catalogue)
    {
        $allProjects = $catalogue->all();
        $categories = $catalogue->categories();
        $selectedCategory = (string) $request->query('category', 'all');

        $projects = $selectedCategory === 'all'
            ? $allProjects
            : $allProjects->where('category_slug', $selectedCategory)->values();

        return view('projects.index', compact('projects', 'allProjects', 'categories', 'selectedCategory'));
    }

    public function show(string $slug, ProjectCatalogue $catalogue)
    {
        $project = $catalogue->find($slug);
        $candidates = $catalogue->all()->reject(fn (array $candidate) => $candidate['slug'] === $slug);

        // Prefer explicitly configured related slugs when present, then rank by
        // category and meaningful title/summary keyword overlap. No route or
        // catalogue schema changes are required.
        $explicitRelated = array_values(array_filter((array) ($project['related'] ?? []), 'is_string'));
        $stopWords = ['system', 'platform', 'management', 'application', 'project', 'and', 'for', 'with', 'from', 'the', 'into', 'using', 'based', 'build', 'create', 'design', 'data', 'service'];
        $tokens = static function (string $text) use ($stopWords): array {
            $words = preg_split('/[^a-z0-9]+/i', Str::lower($text), -1, PREG_SPLIT_NO_EMPTY);
            return array_values(array_unique(array_filter($words, fn ($word) => strlen($word) > 2 && !in_array($word, $stopWords, true))));
        };
        $sourceTokens = $tokens(($project['title'] ?? '') . ' ' . ($project['summary'] ?? ''));

        $relatedProjects = $candidates
            ->map(function (array $candidate) use ($project, $explicitRelated, $tokens, $sourceTokens) {
                $candidateTokens = $tokens(($candidate['title'] ?? '') . ' ' . ($candidate['summary'] ?? ''));
                $overlap = count(array_intersect($sourceTokens, $candidateTokens));
                $score = $overlap * 3;
                if (($candidate['category_slug'] ?? null) === ($project['category_slug'] ?? null)) {
                    $score += 2;
                }
                if (in_array($candidate['slug'], $explicitRelated, true)) {
                    $score += 100;
                }
                $candidate['_related_score'] = $score;
                return $candidate;
            })
            ->filter(fn (array $candidate) => ($candidate['_related_score'] ?? 0) > 0)
            ->sortByDesc('_related_score')
            ->take(3)
            ->map(function (array $candidate) {
                unset($candidate['_related_score']);
                return $candidate;
            })
            ->values();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
