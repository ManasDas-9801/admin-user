<!-- resources/views/emails/user_registration.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Website</title>
</head>
<body>
    <h1>Welcome to Our Website</h1>
    <p>Thank you for registering with us. Here are your account details:</p>
    <p>Email: {{ $userDetails['email']}}</p>
    <p>Password: {{ $userDetails['password'] }}</p>
    <p>Please keep your account details safe and do not share them with others.</p>
    <p>If you have any questions or need assistance, feel free to contact us.</p>
    <p>Best regards,<br>Our Website Team</p>
</body>
</html>
