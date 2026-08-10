@props([
    'type' => 'contact',
    'errorBag' => null,
])

@php
    $captchaError = false;

    if ($errorBag) {
        $captchaError = $errors->getBag($errorBag)->has('captcha');
    } else {
        $captchaError = $errors->has('captcha');
    }
@endphp

<div class="mb-3">

    <label
        class="form-label fw-semibold d-flex align-items-center justify-content-between"
        for="captcha-{{ $type }}"
    >

        <span>
            Solve:
            <span id="captcha-{{ $type }}-text">
                {{ session('captcha_' . $type . '_question') ?? 'Loading...' }}
            </span>
        </span>

        <button
            type="button"
            onclick="refreshCaptcha('{{ $type }}')"
            class="btn btn-sm btn-link text-decoration-none p-0"
            aria-label="Refresh CAPTCHA"
        >
            🔄
        </button>

    </label>


    <input
        id="captcha-{{ $type }}"
        type="text"
        name="captcha"
        class="form-control {{ $captchaError ? 'is-invalid' : '' }}"
        placeholder="Enter answer"
        autocomplete="off"
        required
    >


    @if($errorBag)

        @foreach($errors->getBag($errorBag)->get('captcha') as $error)

            <div class="invalid-feedback">
                {{ $error }}
            </div>

        @endforeach

    @else

        @error('captcha')

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    @endif

</div>
