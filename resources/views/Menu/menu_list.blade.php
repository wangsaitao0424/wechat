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
                <td>name</td>
                <td>操作</td>
            </tr>
            @foreach($list as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{str_repeat('——|  ',$v->level-1).$v->name}}</td>
                <td>
                    <a href="{{url('wechat/menu_del?id='.$v->id)}}">删除</a>
                </td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
</html>