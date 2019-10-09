<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<conten>
    <table border="66">
        <tr>
            <td>nickname</td>
            <td>openid</td>
            <td>sex</td>
            <td>country</td>
            <td>headimgurl</td>
            <td>subscribe_time</td>
        </tr>
        @foreach($list as $v)
        <tr>
            <td>{{$v['nickname']}}</td>
            <td>{{$v['openid']}}</td>
            <td>@if($v['sex']==1)男@else女@endif</td>
            <td>{{$v['country']}}</td>
            <td><img src="{{$v['headimgurl']}}"></td>
            <td>{{date('Y-m-d',$v['subscribe_time'])}}</td>
        </tr>
        @endforeach
    </table>
</conten>
</body>
</html>