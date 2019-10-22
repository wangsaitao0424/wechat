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
    <center>
        <table border="66">
            <tr>
                <td>ID</td>
                <td>姓名</td>
                <td>二维码</td>
                <td>业绩</td>
                <td>操作</td>
            </tr>
            @foreach($list as  $v)
            <tr>
                <td>{{$v->uid}}</td>
                <td>{{$v->name}}</td>
                <td><img src="{{asset($v->qr_url)}}" alt="" width="100"></td>
                <td>{{$v->qr_count}}</td>
                <td><a href="{{url('wechat/add_qr?id='.$v->uid)}}">生成带参数的二维码</a></td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>