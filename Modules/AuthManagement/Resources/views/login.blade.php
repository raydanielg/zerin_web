<!DOCTYPE html>
<html lang="en" dir="{{ session()->get('direction') ?? 'ltr' }}">

<head>
    @php($logo = getSession('header_logo'))
    @php($favicon = getSession('favicon'))
    @php($preloader = getSession('preloader'))
    <!-- Page Title -->
    <title>{{ translate('admin_login') }}</title>
    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $favicon ? dynamicStorage('storage/app/public/business/' . $favicon) : '' }}"/>

    <!-- Web Fonts -->
    <!-- Web Fonts -->
    <link href="{{ dynamicAsset('public/assets/admin-module/css/fonts/google.css') }}" rel="stylesheet">

    <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/bootstrap-icons.min.css') }}"/>
    <link rel="stylesheet"
          href="{{ dynamicAsset('public/assets/admin-module/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}"/>
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/toastr.css') }}"/>
    <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

    <!-- ======= MAIN STYLES ======= -->
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/custom.css') }}"/>
    <!-- ======= END MAIN STYLES ======= -->
    @include('landing-page.layouts.css')

    <!-- Custom Styles for modern login -->
    <style>
        :root {
            --primary-clr: #007bff;
        }
        body {
            background-color: #f8f9fa;
        }
        .login-wrap {
            display: flex;
            min-height: 100vh;
            width: 100%;
            align-items: center;
            justify-content: center;
        }
        .login-left {
            width: 100%;
            max-width: 450px;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        @media (max-width: 576px) {
            .login-left {
                margin: 20px;
                padding: 30px;
            }
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
        }
        .btn-primary {
            border-radius: 8px;
            padding: 12px;
            background-color: #000;
            border: none;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #333;
        }
    </style>
</head>

<body>
<!-- Offcanval Overlay -->
<div class="offcanvas-overlay"></div>
<!-- Offcanval Overlay -->
<!-- Preloader -->
<div class="preloader" id="preloader">
    @if ($preloader)
        <img class="preloader-img" loading="eager" width="160"
             src="{{ dynamicStorage('storage/app/public/business/' . $preloader) }}" alt="">
    @else
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @endif
</div>
<div class="resource-loader d-none" id="resource-loader">
    @if ($preloader)
        <img width="160" loading="eager" src="{{ dynamicStorage('storage/app/public/business/' . $preloader) }}"
             alt="">
    @else
        <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    @endif
</div>
<!-- End Preloader -->
<!-- Login Form -->
<div class="login-form d-block">
    <form action="{{ route('admin.auth.login') }}" enctype="multipart/form-data" method="POST" id="login-form">
        @csrf
        <div class="login-wrap">
            <!-- Centered Form -->
            <div class="login-left">
                <div class="mb-5 text-center">
                    <h2 class="fw-bold mb-2">{{ translate('Sign_In') }}</h2>
                    <p class="text-muted">{{ translate('sign_in_to_stay_connected') }}</p>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-medium">{{ translate('email') }}</label>
                    <input type="email" name="email" class="form-control"
                           placeholder="you@example.com" required id="email"
                           value="{{ request()->cookie('remember_email') }}">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-medium">{{ translate('password') }}</label>
                    <div class="position-relative">
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="********"
                               value="{{ request()->cookie('remember_password') }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ request()->cookie('remember_checked') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ translate('remember_me') }}
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary w-100 mb-4" id="signInBtn" type="submit">
                    {{ translate('sign_in') }} →
                </button>

                @if (env('APP_MODE') == 'demo')
                    <div class="bg-light p-3 rounded mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">{{ translate('email') }}: admin@admin.com</div>
                            <div class="small text-muted">{{ translate('password') }}: 12345678</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-dark" onclick="copyCredentials()">
                            <i class="bi bi-copy"></i>
                        </button>
                    </div>
                @endif
                
                {{-- <div class="text-center mt-4">
                    <span class="small text-muted">
                        {{ translate('Software_Version') }} : {{ env('SOFTWARE_VERSION') }}
                    </span>
                </div> --}}
            </div>
        </div>
    </form>
</div>
<!-- End Login Form -->

<!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
<script src="{{ dynamicAsset('public/assets/admin-module/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ dynamicAsset('public/assets/admin-module/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ dynamicAsset('public/assets/admin-module/js/main.js') }}"></script>
<script src="{{ dynamicAsset('public/assets/admin-module/js/toastr.js') }}"></script>
<script src="{{ dynamicAsset('public/assets/admin-module/js/login.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->

{!! Toastr::message() !!}

@if (env('APP_MODE') == 'demo')
    <script>
        "use strict";

        function copyCredentials() {
            document.getElementById('email').value = 'admin@admin.com';
            document.getElementById('password').value = '12345678'
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        }
    </script>
@endif

@if ($errors->any())
    <script>
        "use strict";
        @foreach ($errors->all() as $error)
        toastr.error('{{ $error }}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
@if(isset($recaptcha) && $recaptcha['status'] == 1)
    <script src="https://www.google.com/recaptcha/api.js?render={{$recaptcha['site_key']}}"></script>
    <script>
        $(document).ready(function () {
            $('#signInBtn').click(function (e) {

                if ($('#set_default_captcha_value').val() == 1) {
                    $('#login-form').submit();
                    return true;
                }

                e.preventDefault();

                if (typeof grecaptcha === 'undefined') {
                    toastr.error('Invalid recaptcha key provided. Please check the recaptcha configuration.');

                    $('#reload-captcha').removeClass('d-none');
                    $('#set_default_captcha_value').val('1');

                    return;
                }

                grecaptcha.ready(function () {
                    grecaptcha.execute('{{$recaptcha['site_key']}}', {action: 'submit'}).then(function (token) {
                        $('#g-recaptcha-response').value = token;
                        $('#login-form').submit();
                    });
                });

                window.onerror = function (message) {
                    var errorMessage = 'An unexpected error occurred. Please check the recaptcha configuration';
                    if (message.includes('Invalid site key')) {
                        errorMessage = 'Invalid site key provided. Please check the recaptcha configuration.';
                    } else if (message.includes('not loaded in api.js')) {
                        errorMessage = 'reCAPTCHA API could not be loaded. Please check the recaptcha API configuration.';
                    }

                    $('#reload-captcha').removeClass('d-none');
                    $('#set_default_captcha_value').val('1');

                    toastr.error(errorMessage)
                    return true;
                };
            });
        });

    </script>

@endif
<script type="text/javascript">
    $('.refresh-recaptcha').on('click', function () {
        let url = "{{ route('admin.auth.default-captcha',':tmp') }}";
        document.getElementById('default_recaptcha_id').src = url.replace(':tmp', Math.random());
    });
</script>

</body>

</html>
