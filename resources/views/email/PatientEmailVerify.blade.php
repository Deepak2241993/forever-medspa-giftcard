<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Verification</h1>
        <p>Thank you for registering with us. Please verify your email address by clicking the button below:</p>
        <p><a href="{{ route('patient_email_verify', ['token' => $data['tokenverify']]) }}" class="button">Verify Email</a></p>
        <p>If you did not create this account, you can ignore this email.</p>
        <div class="footer">
            {{-- <p>&copy; {{date('Y')}} Your Company. All rights reserved.</p> --}}
        </div>
    </div>
</body>
</html>
