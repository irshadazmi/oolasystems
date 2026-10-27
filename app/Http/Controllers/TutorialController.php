<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class TutorialController extends Controller
{
    /**
     * Display the first chapter and chapter list for a tutorial.
     *
     * The tutorial is resolved from the existing named route, so the public
     * URL and route name do not need to change.
     */
    public function index(Request $request)
    {
        $tutorial = $this->tutorialForRoute($request->route()->getName(), 'index');
        $chapters = $this->getChapters($tutorial['content_path']);

        abort_if($chapters->isEmpty(), 404, 'No tutorial chapters are available.');

        $firstChapter = $chapters->first();

        return view('tutorial.index', [
            'tutorial' => $tutorial,
            'chapters' => $chapters,
            'chapterTitle' => $firstChapter['title'],
            'chapterContent' => $this->convertChapter(
                $tutorial['content_path'],
                $firstChapter['slug']
            ),
            'routePrefix' => $tutorial['show_route'],
        ]);
    }

    /**
     * Display a specific chapter and its previous/next navigation.
     */
    public function show(Request $request, string $slug)
    {
        $tutorial = $this->tutorialForRoute($request->route()->getName(), 'show');
        $chapters = $this->getChapters($tutorial['content_path']);
        $chapter = $chapters->firstWhere('slug', $slug);

        abort_unless($chapter, 404);

        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'tutorial' => $tutorial,
            'chapters' => $chapters,
            'chapterTitle' => $chapter['title'],
            'chapterContent' => $this->convertChapter(
                $tutorial['content_path'],
                $slug
            ),
            'routePrefix' => $tutorial['show_route'],
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }

    /**
     * Resolve tutorial configuration from the current named route.
     */
    private function tutorialForRoute(?string $routeName, string $pageType): array
    {
        abort_unless($routeName, 404);

        foreach (config('tutorials.catalog', []) as $tutorial) {
            $configuredRoute = $pageType === 'index'
                ? ($tutorial['index_route'] ?? null)
                : ($tutorial['show_route'] ?? null);

            if ($configuredRoute === $routeName) {
                return $tutorial;
            }
        }

        abort(404, 'Tutorial not found.');
    }

    /**
     * Discover Markdown chapters and read their H1 headings as titles.
     * Natural sorting ensures chapter2.md appears before chapter10.md.
     */
    private function getChapters(string $contentPath): Collection
    {
        $directory = resource_path($contentPath);

        abort_unless(File::isDirectory($directory), 404, 'Tutorial content not found.');

        return collect(File::files($directory))
            ->filter(fn ($file) => strtolower($file->getExtension()) === 'md')
            ->map(function ($file) {
                $slug = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $content = File::get($file->getPathname());

                preg_match('/^#\s+(.+)$/m', $content, $matches);

                return [
                    'slug' => $slug,
                    'title' => trim($matches[1] ?? ucfirst(str_replace('-', ' ', $slug))),
                ];
            })
            ->sortBy('slug', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    /**
     * Convert a Markdown chapter to HTML using the same CommonMark library
     * already used by the existing controller.
     */
    private function convertChapter(string $contentPath, string $slug): string
    {
        // Only accept a slug discovered from the Markdown chapter list.
        abort_unless(preg_match('/^[A-Za-z0-9_-]+$/', $slug), 404);

        $path = resource_path($contentPath . DIRECTORY_SEPARATOR . $slug . '.md');

        abort_unless(File::exists($path), 404);

        $converter = new GithubFlavoredMarkdownConverter();

        return (string) $converter->convert(File::get($path));
    }

    /**
     * Return previous and next chapter slugs.
     */
    private function getChapterNavigation(Collection $chapters, string $slug): array
    {
        $slugs = $chapters->pluck('slug')->values();
        $currentIndex = $slugs->search($slug);

        abort_if($currentIndex === false, 404);

        return [
            'prevChapter' => $currentIndex > 0 ? $slugs[$currentIndex - 1] : null,
            'nextChapter' => $currentIndex < $slugs->count() - 1
                ? $slugs[$currentIndex + 1]
                : null,
        ];
    }
}
