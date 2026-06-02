<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Reset Password</title>
    <style>
        body {
            font-family: Inter, system-ui, -apple-system, Arial, sans-serif;
            background-color: #ffe9d6;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header {
            background-color: #f57c00;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            letter-spacing: 0.5px;
        }
        .body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .body p {
            margin: 0 0 20px 0;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            background-color: #f57c00;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            margin: 10px 0 20px 0;
            text-align: center;
        }
        .btn:hover {
            background-color: #e65100;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            border-top: 1px solid #eeeeee;
        }
        .small-text {
            font-size: 12px;
            color: #9ca3af;
            word-break: break-all;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="header">
        <h1>Admin Security Alert</h1>
    </div>
    
    <div class="body">
        <p>Hello Admin,</p>
        <p>You are receiving this email because we received a password reset request for your CrackerStore administrative account.</p>
        
        <div style="text-align: center;">
            <a href="{{ $url }}" class="btn">Reset Password</a>
        </div>
        
        <p>This password reset link will expire in 60 minutes.</p>
        <p>If you did not request a password reset, no further action is required.</p>
        
        <p style="margin-bottom: 0;">Regards,<br>CrackerStore System</p>
        
        <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 30px 0;">
        
        <p class="small-text">
            If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
            <a href="{{ $url }}" style="color: #f57c00;">{{ $url }}</a>
        </p>
    </div>
    
    <div class="footer">
        &copy; {{ date('Y') }} CrackerStore. All rights reserved.
    </div>
</div>

</body>
</html>
