<!DOCTYPE html>
<html lang="{{\Illuminate\Support\Facades\App::getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['body_type'] ?? 'Verification Code' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0;">

    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="background-color: #4caf50; color: #ffffff; text-align: center; padding: 20px;">
            <h1 style="margin: 0; font-size: 24px;">{{ $details['body_type'] ?? 'Verification Code' }}</h1>
        </div>

        <div style="padding: 20px; text-align: center; line-height: 1.6;">
            <p style="font-size: 18px; margin: 20px 0;">{{ $details['title'] ?? 'Your verification code is:' }}</p>
            <p style="font-size: 32px; font-weight: bold; color: #4caf50; margin: 20px 0; letter-spacing: 2px;">
                {{ $details['code'] }}
            </p>
            <p style="font-size: 16px; color: #555;">{{ $details['body'] ?? 'Use this code to as your one time password. Please note that the code is valid for a limited time only.' }}</p>
        </div>

        <div style="background-color: #f4f4f9; padding: 15px; text-align: center; border-top: 1px solid #dddddd;">
            <p style="font-size: 14px; color: #888;">{{ $details['footer'] ?? 'If you did not request a verification code, please ignore this email or contact support.'}}</p>
        </div>
    </div>

</body>
</html>
