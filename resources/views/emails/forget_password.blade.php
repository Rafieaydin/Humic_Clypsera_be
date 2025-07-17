<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto,
                'Helvetica Neue', Arial, sans-serif;
            background-color: #4971a9;
            /* Fallback background color */
        }

        .layout-container {
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .wave-background {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            z-index: 0;
            pointer-events: none;
        }

        .wave-background img {
            width: 100%;
            display: block;
        }

        .wave-background .wave2,
        .wave-background .wave3 {
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .reset-card {
            position: relative;
            z-index: 10;
            background-color: white;
            padding: 30px 40px;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            margin: 20px;
            text-align: center;
        }

        .reset-card .logo {
            width: 160px;
            height: auto;
            margin-bottom: 20px;
        }

        .reset-card .title {
            color: #4971a9;
            font-size: 34px;
            font-weight: 600;
            margin: 0 0 30px 0;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
            width: 100%;
        }

        .input-group .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            pointer-events: none;
        }

        .input-field {
            height: 44px;
            width: 100%;
            border: none;
            background-color: #f4f8f7;
            border-radius: 5px;
            padding-left: 50px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .input-field:focus {
            outline: 1px solid #4971a9;
        }

        .submit-button {
            height: 44px;
            width: 200px;
            margin: 20px auto 0;
            cursor: pointer;
            border-radius: 9999px;
            background-color: #4971a9;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .submit-button:hover {
            background-color: #3e6194;
        }

        .form-validation {
            color: #e3342f;
            font-size: 14px;
            margin-top: 5px;
            text-align: left !important;
            display: block;

        }

        @media (max-width: 500px) {
            .reset-card {
                padding: 25px;
            }

            .reset-card .title {
                font-size: 28px;
            }
        }


    </style>
</head>

<body>
    <div class="layout-container">
        <div class="reset-card">
            <img src="{{ asset('images/reset_password/LOGO.svg') }}" alt="Clypsera Logo" class="logo" />
            <p class="title">Reset Password</p>

            <form action="{{ route('reset.password.post') }}" method="POST" class="form-container">
               @csrf
                <input type="hidden" name="token" value="{{ $token }}" />

                <div class="input-group">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </span>
                    <input type="email" name="email" class="input-field" value="{{ $email ?? old('email') }}"
                        readonly />
                        @if($errors->has('email'))
                            <span  span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                </div>

                <div class="input-group">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input type="password" name="password" class="input-field" placeholder="New Password" value="{{ old('password') }}"  />
                    @error('password')
                        <div>
                            <span class="text-danger form-validation">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="input-group">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" class="input-field"
                        placeholder="Confirm Password"  value="{{ old('password_confirmation') }}" />
                        @error('password_confirmation')
                            <div>
                                <span class="text-danger form-validation">{{ $message }}</span>
                            </div>
                        @enderror
                </div>

                <button type="submit" class="submit-button">Reset Password</button>
            </form>
        </div>

        <div class="wave-background">
            <img src="{{ asset('images/reset_password/ombak1.svg') }}" alt="Wave Background 1" class="wave1" />
            <img src="{{ asset('images/reset_password/ombak2.svg') }}" alt="Wave Background 2" class="wave2" />
            <img src="{{ asset('images/reset_password/ombak3.svg') }}" alt="Wave Background 3" class="wave3" />
        </div>
    </div>
</body>

</html>
