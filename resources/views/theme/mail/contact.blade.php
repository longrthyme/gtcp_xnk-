<!DOCTYPE html>
<html>
<head>
    <title>{{ $detail['subject']??'Liên hệ' }}</title>
</head>

<body>
    @if(!empty($detail['subject']))
    <h1>{{ $detail['subject'] }}</h1>
    @endif
    @if(!empty($detail['message']))
    <div>{!! $detail['message'] !!}</div>
    @endif
    <br>
    <hr>
    
    @if(!empty($detail['name']))
    <div>From: {{ $detail['name'] }}</div>
    @endif
    @if(!empty($detail['email']))
    <div>Email: {{ $detail['email'] }}</div>
    @endif
    @if(!empty($detail['phone']))
    <div>Phone: {{ $detail['phone'] }}</div>
    @endif
    @if(!empty($detail['company']))
    <div>Company: {{ $detail['company'] }}</div>
    @endif

</body>
</html>