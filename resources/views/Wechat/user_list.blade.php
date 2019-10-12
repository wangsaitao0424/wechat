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
    <form action="{{url('wechat/add_user')}}" method="post">
        @csrf
        <input type="hidden" name="tag_id" value="{{$tag_id['tag_id']}}">
        <table border="66">
            <tr>
                <td></td>
                <td>nickname</td>
                <td>openid</td>
                <td>sex</td>
                <td>country</td>
                <td>headimgurl</td>
                <td>subscribe_time</td>
                <td>操作</td>
            </tr>
            @foreach($list as $v)
            <tr>
                <td><input type="checkbox" name="openid_list[]" value="{{$v['openid']}}"></td>
                <td>{{$v['nickname']}}</td>
                <td>{{$v['openid']}}</td>
                <td>@if($v['sex']==1)男@else女@endif</td>
                <td>{{$v['country']}}</td>
                <td><img src="{{$v['headimgurl']}}"></td>
                <td>{{date('Y-m-d',$v['subscribe_time'])}}</td>
                <td><a href="{{url('wechat/user_tag')}}?openid={{$v['openid']}}">查看用户的标签</a></td>
            </tr>
            @endforeach
        </table>
        <input type="submit" value="添加标签">
    </form>
</center>
</body>
</html>