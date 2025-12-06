<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        padding: 20px;
    }

    .container {
        max-width: 500px;
        background: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .otp-code {
        font-size: 24px;
        font-weight: bold;
        color: #d9534f;
    }

    .footer {
        font-size: 12px;
        color: gray;
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <p class="otp-code">{{ $otp }}</p>
        <p>This OTP is valid for **5 minutes**. Please do not share it with anyone.</p>
        <p class="footer">If you didn't request this, please ignore this email.</p>
    </div>
</body>

</html>