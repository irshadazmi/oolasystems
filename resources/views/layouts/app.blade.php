<!DOCTYPE html>
<html lang="en">
<head>

    @include('components.head')

</head>

<body class="d-flex flex-column min-vh-100 site-body">
    <a class="skip-link" href="#main-content">
        Skip to main content
    </a>

    <div class="main-container d-flex flex-column min-vh-100">
        @include('components.navbar')

        <div class="site-shell">
            <main id="main-content" class="content-area flex-grow-1">
                @yield('content')
            </main>

            @include('components.footer')
        </div>
    </div>

    @include('components.scripts')
</body>

</html>
