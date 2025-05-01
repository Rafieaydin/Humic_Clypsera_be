<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        /* Reset default styles */
        body, table, td, a, p, h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        body {
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
        }
        .cta-button:hover {
            background-color: #0056b3;
        }
        .fallback-link {
            word-break: break-all;
            color: #007bff;
            text-decoration: underline;
        }
        .footer {
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            color: #666666;
            font-size: 14px;
        }
        .footer p {
            margin: 0;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                padding: 0;
            }
            .content {
                padding: 20px;
            }
            .header h1 {
                font-size: 20px;
            }
            .cta-button {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Reset Your Password</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello,</p>
            <p>We received a request to reset your password. Click the button below to proceed:</p>
            <p>
                <a href="{{ route('password.reset', $token) }}" class="cta-button">Reset Password</a>
            </p>
            <p>If the button doesn’t work, copy and paste this link into your browser:</p>
            <p><a href="{{ $url }}" class="fallback-link">{{ $url }}</a></p>
            <p>If you did not request a password reset, please ignore this email or contact our support team.</p>
            <p>Thank you,</p>
            <p>Your App Team</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your App. All rights reserved.</p>
            <p>If you have any questions, contact us at <a href="mailto:support@yourdomain.com">support@yourdomain.com</a>.</p>
        </div>
    </div>
</body>
</html>
