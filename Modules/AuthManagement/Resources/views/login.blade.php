<!DOCTYPE html>
<html lang="en" dir="{{ session()->get('direction') ?? 'ltr' }}">

<head>
    @php($logo = getSession('header_logo'))
    @php($favicon = getSession('favicon'))
    @php($preloader = getSession('preloader'))
    <title>{{ translate('admin_login') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ $favicon ? dynamicStorage('storage/app/public/business/' . $favicon) : '' }}"/>

    <link href="{{ dynamicAsset('public/assets/admin-module/css/fonts/google.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/bootstrap-icons.min.css') }}"/>
    <link rel="stylesheet" href="{{ dynamicAsset('public/assets/admin-module/css/toastr.css') }}"/>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Nunito', 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
        }
        .bg-layer img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .bg-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(2,73,56,0.92) 0%, rgba(2,61,48,0.88) 50%, rgba(1,48,40,0.85) 100%);
        }
        .bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.1;
            background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.12);
            overflow: hidden;
            animation: cardSlideIn 0.5s cubic-bezier(0.16,1,0.3,1) both;
            border: 1px solid rgba(0,0,0,0.04);
        }
        @keyframes cardSlideIn {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-header {
            background: linear-gradient(135deg, #024938 0%, #013028 100%);
            padding: 40px 32px 28px;
            text-align: center;
            position: relative;
        }
        .logo-wrap {
            margin: 0 auto 16px;
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(4px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-wrap img {
            max-width: 40px;
            max-height: 40px;
            object-fit: contain;
        }
        .logo-wrap i {
            font-size: 28px;
            color: rgba(255,255,255,0.9);
        }
        .login-header h2 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .login-header p {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
        }

        .login-body {
            padding: 28px 36px 36px;
        }

        .field-group {
            margin-bottom: 20px;
        }
        .field-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .field-wrap {
            position: relative;
        }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
            pointer-events: none;
        }
        .field-input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
            background: #f9fafb;
        }
        .field-input:focus {
            border-color: #024938;
            box-shadow: 0 0 0 3px rgba(2,73,56,0.1);
            background: #fff;
        }
        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0;
        }
        .pw-toggle:hover { color: #6b7280; }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .remember-check input {
            width: 16px;
            height: 16px;
            accent-color: #024938;
            cursor: pointer;
        }
        .remember-check span {
            font-size: 0.82rem;
            color: #6b7280;
        }

        .btn-signin {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #f9ac00 0%, #d49700 100%);
            color: #1a1a1a;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(249,172,0,0.25);
        }
        .btn-signin:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(249,172,0,0.35);
        }
        .btn-signin:active {
            transform: translateY(0);
        }

        .demo-box {
            margin-top: 20px;
            padding: 14px 16px;
            background: #f3f4f6;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .demo-box .demo-text {
            font-size: 0.78rem;
            color: #6b7280;
        }
        .demo-box .demo-text strong {
            color: #374151;
        }
        .demo-copy-btn {
            background: none;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.75rem;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s;
        }
        .demo-copy-btn:hover {
            background: #e5e7eb;
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            .login-card { max-width: 100%; }
            .login-header { padding: 28px 24px 20px; }
            .login-body { padding: 20px 24px 28px; }
        }
    </style>
</head>

<body>
<div class="bg-layer">
    <div class="bg-overlay"></div>
    <div class="bg-pattern"></div>
</div>

<div class="login-card">
    <div class="login-header">
        <div class="logo-wrap">
            @if($logo)
                <img src="{{ dynamicStorage('storage/app/public/business/' . $logo) }}" alt="Logo">
            @else
                <i class="bi bi-shield-lock-fill"></i>
            @endif
        </div>
        <h2>{{ translate('Sign_In') }}</h2>
        <p>{{ translate('sign_in_to_stay_connected') }}</p>
    </div>

    <div class="login-body">
        <form action="{{ route('admin.auth.login') }}" method="POST" id="login-form">
            @csrf
            <input type="hidden" id="set_default_captcha_value" value="0">
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

            <div class="field-group">
                <label for="email" class="field-label">{{ translate('email') }}</label>
                <div class="field-wrap">
                    <i class="bi bi-envelope field-icon"></i>
                    <input type="email" name="email" id="email" class="field-input"
                           placeholder="you@example.com" required
                           value="{{ request()->cookie('remember_email') }}">
                </div>
            </div>

            <div class="field-group">
                <label for="password" class="field-label">{{ translate('password') }}</label>
                <div class="field-wrap">
                    <i class="bi bi-lock field-icon"></i>
                    <input type="password" name="password" id="password" class="field-input"
                           placeholder="********" required
                           value="{{ request()->cookie('remember_password') }}">
                    <button type="button" class="pw-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            <div class="remember-row">
                <label class="remember-check">
                    <input type="checkbox" name="remember" id="remember" {{ request()->cookie('remember_checked') ? 'checked' : '' }}>
                    <span>{{ translate('remember_me') }}</span>
                </label>
            </div>

            <button class="btn-signin" id="signInBtn" type="submit">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>{{ translate('sign_in') }}</span>
            </button>
        </form>

        @if (env('APP_MODE') == 'demo')
            <div class="demo-box">
                <div class="demo-text">
                    <div><strong>Email:</strong> admin@admin.com</div>
                    <div><strong>Password:</strong> 12345678</div>
                </div>
                <button type="button" class="demo-copy-btn" onclick="copyCredentials()">
                    <i class="bi bi-copy"></i> Copy
                </button>
            </div>
        @endif

        <div class="login-footer">
            &copy; {{ date('Y') }} {{ env('APP_NAME', 'DriveMond') }}. All rights reserved.
        </div>
    </div>
</div>

<script src="{{ dynamicAsset('public/assets/admin-module/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ dynamicAsset('public/assets/admin-module/js/toastr.js') }}"></script>
<script src="{{ dynamicAsset('public/assets/admin-module/js/login.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

{!! Toastr::message() !!}

<script>
    function togglePassword() {
        const pw = document.getElementById('password');
        const icon = document.getElementById('pwIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            pw.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    @if (env('APP_MODE') == 'demo')
    function copyCredentials() {
        document.getElementById('email').value = 'admin@admin.com';
        document.getElementById('password').value = '12345678';
        toastr.success('Credentials filled successfully!', 'Success', {
            CloseButton: true,
            ProgressBar: true
        });
    }
    @endif
</script>

@if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
        toastr.error('{{ addslashes($error) }}', 'Error', {
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
