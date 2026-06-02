<!DOCTYPE html>
<html>
<head>
    <title>Reply to Your Inquiry</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div style="background: #ff6600; padding: 20px; text-align: center; color: #ffffff;">
            <h2 style="margin: 0;">Crackers Time</h2>
        </div>
        <div style="padding: 30px;">
            <p>Dear {{ $inquiry->name }},</p>
            <p>Thank you for reaching out to us. We have received your inquiry and here is our response:</p>
            
            <div style="background: #f9f9f9; border-left: 4px solid #ff6600; padding: 15px; margin: 20px 0; white-space: pre-wrap;">{{ $replyMessage }}</div>
            
            <p><strong>Your Original Message:</strong></p>
            <div style="background: #f0f0f0; border: 1px solid #e0e0e0; padding: 15px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9em; color: #555; white-space: pre-wrap;">{{ $inquiry->message }}</div>

            <p>If you have any further questions, please feel free to reply directly to this email.</p>
            <p>Best regards,<br>The Crackers Time Team</p>
        </div>
    </div>
</body>
</html>
