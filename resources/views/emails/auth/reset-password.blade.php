<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Wismilak Premium Cigars</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #0D0805;
            color: #F5EBE0;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
        }
        .email-wrapper {
            width: 100%;
            background-color: #0D0805;
            padding: 40px 0;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1A130F;
            border: 1px solid #33271A;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #0D0805;
            padding: 30px;
            text-align: center;
            border-bottom: 2px solid #D4AF37;
        }
        .header h1 {
            color: #D4AF37;
            font-size: 24px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 4px;
        }
        .body {
            padding: 40px 30px;
        }
        .body p {
            color: #E8E8ED;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .button-wrapper {
            text-align: center;
            margin: 40px 0;
        }
        .button {
            display: inline-block;
            background-color: #D4AF37;
            color: #000000 !important;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer {
            background-color: #0D0805;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #33271A;
        }
        .footer p {
            color: #8A8A9A;
            font-size: 12px;
            line-height: 1.5;
            margin: 0;
        }
        .text-gold {
            color: #D4AF37;
        }
        .sub-text {
            font-size: 13px;
            color: #8A8A9A !important;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="header">
                <h1>Wismilak Premium</h1>
            </div>
            
            <div class="body">
                <p>Hello <span class="text-gold">{{ $user->name }}</span>,</p>
                
                <p>We received a request to reset the password for your Wismilak Premium Cigars account. You can reset your password by clicking the button below:</p>
                
                <div class="button-wrapper">
                    <a href="{{ $url }}" class="button">Reset Password</a>
                </div>
                
                <p>This password reset link will expire in 60 minutes.</p>
                
                <p>If you did not request a password reset, no further action is required. Your account remains secure.</p>
                
                <p style="margin-top: 40px;">
                    Best regards,<br>
                    <span class="text-gold">The Wismilak Team</span>
                </p>

                <hr style="border: none; border-top: 1px solid #33271A; margin: 30px 0;">
                
                <p class="sub-text">
                    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
                    <a href="{{ $url }}" style="color: #D4AF37;">{{ $url }}</a>
                </p>
            </div>
            
            <div class="footer">
                <p>&copy; {{ date('Y') }} Wismilak Premium Cigars. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
