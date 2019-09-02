<!DOCTYPE html>
<html>
<head>
    <title>Confirm your email address!</title>
</head>

<body>
<p>Hi {{$user['name']}},</p>
<p>Thank you for visiting WorkPerk. You are one click away from verifying your account and unlocking the features on the platform.</p>
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a>
<br/>
<br/>
<p>Regards,</p>
<p>Shazwi Suwandi.</p>
</body>

</html>