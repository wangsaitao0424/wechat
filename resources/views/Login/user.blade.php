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
    <table border="66">
        <tr>
            <td>openid</td>
            <td>操作</td>
        </tr>
        @foreach($users as $v)
        <tr>
            <td>{{$v}}</td>
            <td><a href="{{url('week_test/login_news?openid='.$v)}}">发送消息</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>