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
<form action="{{url('wechat/do_update_tog')}}" method="post">
    @csrf
    <input type="hidden" name="tag_id" value="{{$tag_id}}">
    标签：<input type="text" name="tag_name" value="{{$tag_name}}">
    <input type="submit" value="提交">
</form>

</body>
</html>