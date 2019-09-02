<!DOCTYPE html>
<html>
<head>
    <title>Project purchased!</title>
</head>

<body>
<p>Hi {{$creator['name']}},</p>
<p>Someone has purchased your project(s): </p>
@foreach($projects as $key=>$project) 
	<p>{{$key+1}}. {{$project}}</p>
@endforeach
<br/>
<br/>
<p>Regards,</p>
<p>Team Talentail.</p>
</body>

</html>