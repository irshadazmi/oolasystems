@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.tutorial-sidebar')
        </div>
        <div class="col-md-9">
            @yield('tutorial-content')
        </div>
    </div>
@endsection