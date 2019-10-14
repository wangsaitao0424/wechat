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
        <button class="do">添加标签</button>
        {{--<button class="list">粉丝列表</button>--}}
        <table border="66">
            <tr>
                <td>标签ID</td>
                <td>标签名称</td>
                <td>操作</td>
            </tr>
            @foreach($data as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>
                    <a href="{{url('/wechat/update_tog')}}?tag_id={{$v['id']}}&tag_name={{$v['name']}}">修改</a>||
                    <a href="{{url('/wechat/del_tog')}}?tag_id={{$v['id']}}">删除</a>||
                    <a href="{{url('/wecaht/access')}}?tag_id={{$v['id']}}">给粉丝打标签</a>||
                    <a href="{{url('/wechat/tag_user')}}?tag_id={{$v['id']}}">标签下的粉丝</a>
                </td>
            </tr>
            @endforeach
        </table>
    </center>
</body>
<script src="/js/jq.js"></script>
<script>
    $('.do').click(function () {
        location.href="{{env('APP_URL').'/wechat/add_tog'}}";
    })
    {{--$('.list').click(function () {--}}
        {{--location.href="{{env('APP_URL').'/wecaht/access'}}";--}}
    {{--})--}}
</script>
</html>