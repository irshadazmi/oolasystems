<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class TutorialController extends Controller
{
    // Java Fundamentals Index
    public function javaFundamentalsIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/javafundamentals');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/javafundamentals/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.javafundamentals.show'
        ]);
    }

    // Java Fundamentals Show
    public function javaFundamentalsShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/javafundamentals');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/javafundamentals/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.javafundamentals.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }

    // React Native Index
    public function reactNativeIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/reactnative');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/reactnative/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.reactnative.show'
        ]);
    }

    // React Native Show
    public function reactNativeShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/reactnative');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/reactnative/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.reactnative.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }


    // Agentic AI Index
    public function agenticAIIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/agenticai');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/agenticai/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.agenticai.show'
        ]);
    }

    // Agentic AI Show
    public function agenticAIShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/agenticai');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/agenticai/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.agenticai.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }


    // GCP Data Modeling Index
    public function gcpDataModelingIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/gcpdatamodeling');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/gcpdatamodeling/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.gcpdatamodeling.show'
        ]);
    }

    // GCP Data Modeling Show
    public function gcpDataModelingShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/gcpdatamodeling');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/gcpdatamodeling/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.gcpdatamodeling.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }


    // Selenium Index
    public function seleniumIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/selenium');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/selenium/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.selenium.show'
        ]);
    }

    // Selenium Show
    public function seleniumShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/selenium');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/selenium/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.selenium.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }

    // Spring Boot Index
    public function springBootIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/springboot');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/springboot/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.springboot.show'
        ]);
    }

    // Spring Boot Show
    public function springBootShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/springboot');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/springboot/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.springboot.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }

    // .NET Fundamentals Index
    public function dotnetFundamentalIndex()
    {
        $chapters = $this->getChapters('views/content/tutorials/dotnet/fundamental');
        $first = $chapters->first();

        $converter = new GithubFlavoredMarkdownConverter();
        $path = resource_path("views/content/tutorials/dotnet/fundamental/{$first['slug']}.md");

        $chapterContent = File::exists($path)
            ? $converter->convert(File::get($path))
            : '';

        return view('tutorial.index', [
            'chapters' => $chapters,
            'chapterTitle' => $first['title'],
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.dotnet.fundamental.show'
        ]);
    }

    // .NET Fundamentals Show
    public function dotnetFundamentalShow($slug)
    {
        $chapters = $this->getChapters('views/content/tutorials/dotnet/fundamental');

        $converter = new GithubFlavoredMarkdownConverter();

        $path = resource_path("views/content/tutorials/dotnet/fundamental/{$slug}.md");

        if (!File::exists($path)) {
            abort(404);
        }

        $chapterContent = $converter->convert(File::get($path));

        // Navigation
        $navigation = $this->getChapterNavigation($chapters, $slug);

        return view('tutorial.show', [
            'chapters' => $chapters,
            'chapterTitle' => ucfirst(str_replace('-', ' ', $slug)),
            'chapterContent' => $chapterContent,
            'routePrefix' => 'tutorial.dotnet.fundamental.show',

            // Navigation
            'prevChapter' => $navigation['prevChapter'],
            'nextChapter' => $navigation['nextChapter'],
        ]);
    }

    // Shared helper
    private function getChapters($folder = 'views/content/tutorials/reactnative')
    {
        $files = File::files(resource_path($folder));

        return collect($files)->map(function ($file) {
            $slug = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $content = File::get($file->getPathname());

            preg_match('/^#\s+(.*)$/m', $content, $matches);
            $title = $matches[1] ?? ucfirst(str_replace('-', ' ', $slug));

            return [
                'slug'  => $slug,
                'title' => $title,
            ];
        })->sortBy('slug')->values();
    }

    private function getChapterNavigation($chapters, $slug)
    {
        $slugs = $chapters->pluck('slug')->values();

        $currentIndex = $slugs->search($slug);

        return [
            'prevChapter' => $currentIndex > 0
                ? $slugs[$currentIndex - 1]
                : null,

            'nextChapter' => $currentIndex < $slugs->count() - 1
                ? $slugs[$currentIndex + 1]
                : null,
        ];
    }
}
