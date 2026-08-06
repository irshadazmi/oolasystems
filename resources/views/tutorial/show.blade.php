@extends('layouts.tutorial')

@section('tutorial-content')
    <div class="tutorial-content markdown-body">
        {!! $chapterContent !!}
    </div>
    {{-- =========================
     PREVIOUS / NEXT / TOP
    ========================= --}}
    <div class="tutorial-navigation">

        {{-- Previous --}}
        <div>
            @if ($prevChapter)
                <a href="{{ route($routePrefix, $prevChapter) }}" class="btn btn-outline-primary tutorial-nav-btn">

                    <i class="bi bi-arrow-left"></i>
                    Previous

                </a>
            @endif
        </div>

        {{-- Top --}}
        <div>
            <a href="#" class="btn btn-dark tutorial-nav-btn"
                onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">

                <i class="bi bi-arrow-up"></i>
                Top

            </a>
        </div>

        {{-- Next --}}
        <div>
            @if ($nextChapter)
                <a href="{{ route($routePrefix, $nextChapter) }}" class="btn btn-primary tutorial-nav-btn">

                    Next
                    <i class="bi bi-arrow-right"></i>

                </a>
            @endif
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("pre").forEach((block) => {
                // Create button
                const button = document.createElement("button");
                button.innerText = "Copy";
                button.className = "copy-btn";

                // Wrap pre in container
                const wrapper = document.createElement("div");
                wrapper.className = "code-block-wrapper";

                block.parentNode.insertBefore(wrapper, block);
                wrapper.appendChild(block);
                wrapper.appendChild(button);

                button.addEventListener("click", () => {
                    const code = block.innerText;

                    navigator.clipboard.writeText(code).then(() => {
                        button.innerText = "Copied!";
                        button.classList.add("copied");

                        setTimeout(() => {
                            button.innerText = "Copy";
                            button.classList.remove("copied");
                        }, 2000);
                    });
                });
            });
        });
    </script>
@endpush
