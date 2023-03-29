<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invitation</title>
</head>

<body style="font-family: Arial, sans-serif;">
    <h2>Invitation to Join us</h2>
    <p>Dear,</p>
    <p>I am writing to invite you to join us for Conference. This event will be a great opportunity. We would be
        delighted to have you join us.</p>
    <p>To access the event, please use the following link:
        <a href="{{ url('/register') . '/?code=' . $referral->code }}">Click here</a>.
    </p>
    <p>We have an exciting agenda planned for the event, including:</p>
    <p>We look forward to seeing you at the event.</p>
    <p>Best regards,</p>
    <p>{{ $referral->referredBy->name }}</p>
</body>

</html>
