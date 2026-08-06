<!DOCTYPE html>

<html lang="en">

<head>

    @include('components.head')

    <title>Admin Login | Oola Systems</title>

</head>

<body class="site-body">

    <section class="section-block auth-page">

        <div class="row justify-content-center">

            <div class="col-lg-5 col-md-7">

                <div class="feature-card">

                    <div class="text-center mb-4">

                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <img src="{{ asset('images/os-logo.png') }}" alt="Oola Systems" style="height:70px">
                        </div>
                        <div class="eyebrow">

                            Administration

                        </div>

                        <h1 class="section-title mb-3">

                            Admin Login

                        </h1>

                        <p class="section-subtitle">

                            Sign in to access the Oola Systems Administration Portal.

                        </p>

                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>
                    @endif

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">

                        @csrf

                        <div class="mb-4">

                            <label class="form-label">

                                Email Address

                            </label>

                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                required autofocus>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Password

                            </label>

                            <input type="password" name="password" class="form-control" required>

                        </div>

                        <div class="form-check mb-4">

                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">

                                Remember Me

                            </label>

                        </div>

                        <button type="submit" class="btn btn-primary w-100">

                            <i class="bi bi-box-arrow-in-right"></i>

                            Login

                        </button>

                    </form>

                    <hr class="my-4">

                    <div class="text-center">

                        <a href="{{ route('home') }}" class="btn btn-outline-light">

                            <i class="bi bi-house"></i>

                            Back to Website

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    @include('components.scripts')

</body>

</html>
