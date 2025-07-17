<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Your Password</title>
    <style>
        body,
        table,
        td,
        a,
        p,
        h1 {
            margin: 0;
            padding: 0;
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        /* Header */
        .header {
            padding: 25px 30px;
            text-align: center;
            background-color: #f8fafc;
        }

        .header img {
            max-width: 160px;
        }

        /* Content */
        .content {
            padding: 30px 40px;
            color: #334155;
            line-height: 1.6;
        }

        .content h1 {
            font-size: 24px;
            font-weight: 600;
            color: #4971a9;
            margin-bottom: 20px;
            text-align: center;
        }

        .content p {
            margin-bottom: 25px;
            font-size: 16px;
        }

        .content .closing {
            margin-bottom: 0;
        }

        .content .team-name {
            font-size: 16px;
            font-weight: 600;
            color: #4971a9;
            margin-bottom: 0;
        }

        .cta-button-container {
            text-align: center;
            margin: 30px 0;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 35px;
            background-color: #4971a9;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer {
            padding: 20px;
            text-align: center;
            background-color: #f1f5f9;
            color: #64748b;
            font-size: 13px;
        }

        .footer p {
            margin: 0;
        }

        .footer a {
            color: #4971a9;
            text-decoration: underline;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                border-radius: 0;
            }

            .content {
                padding: 25px;
            }
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/reset_password/LOGO.svg') }}" alt="Clypsera Logo" />
        </div>

        <div class="content">
            <h1>Reset Your Password</h1>
            <p>Hello,</p>
            <p>
                We received a request to reset your password. Click the button below
                to proceed:
            </p>
            <div class="cta-button-container">
                <a href="{{ route('password.reset', $token) }}" class="cta-button">Reset Password</a>
            </div>
            <p>
                If the button doesn’t work, copy and paste this link into your
                browser:
            </p>
            <p><a href="{{ $url }}" class="fallback-link">{{ $url }}</a></p>
            <p>
                If you did not request a password reset, please ignore this email or
                contact our support team.
            </p>
            <p>Thank you,</p>
            <p class="team-name">Humic Cleft Lip | Clypsera 2025</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Your App. All rights reserved.</p>
            <p>
                If you have any questions, contact us at
                <a href="mailto:support@yourdomain.com">support@yourdomain.com</a>.
            </p>
        </div>
    </div>
</body>

</html>
