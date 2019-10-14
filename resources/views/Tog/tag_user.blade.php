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
    <form action="{{url('wechat/on_user_tag')}}" method="post">
        @csrf
        <input type="hidden" name="tag_id" value="{{$tag_id['tag_id']}}">
        <table border="66">
            <tr>
                <td></td>
                <td>openid</td>
                {{--<td>操作</td>--}}
            </tr>
            @if($list['count']==0)
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            @else
                @foreach($list['data']['openid'] as $v)
                    <tr>
                        <td><input type="checkbox" name="openid_list[]" value="{{$v}}"></td>

                        <td>{{$v}}</td>
                        {{--<td><a href="{{url('wechat/user_tag')}}?openid={{$v}}"></a></td>--}}
                    </tr>
                @endforeach
            @endif
        </table>
        <input type="submit" value="批量为用户取消标签">
    </form>
</center>

</body>
</html>