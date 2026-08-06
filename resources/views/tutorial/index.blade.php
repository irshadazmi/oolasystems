@extends('layouts.tutorial')

@section('tutorial-content')
    {{-- <h1>{{ $chapterTitle }}</h1> --}}
    <div class="markdown-body">
        {!! $chapterContent !!}
    </div>
@endsection
