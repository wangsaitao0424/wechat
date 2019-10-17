<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<center>
    <h1>素材管理</h1>
    <tr>
        <td><button class="image">image</button></td>
        <td><button class="voice">voice</button></td>
        <td><button class="video">video</button></td>
        <td><button class="thumb">thumb</button></td>
    </tr>
    <table border="1">
        <tr>
            <td>id</td>
            <td>media_id</td>
            <td>path</td>
            <td>type</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        <br>
        @foreach($res as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ $v->media_id }}</td>
                <td>
                    {{----}}
                    @if($v->type==1)
                        <img src="{{$v->path}}" alt="" height="100">
                    @else
                       <a href="{{ $v->path }}">点击查看</a>
                    @endif
                </td>
                <td>
                    @if($v->type==1)图片@elseif($v->type==2)音频@elseif($v->type==3)视频@elseif($v->type==4)缩率图@endif
                </td>
                <td>{{ date('Y-m-d H:i:s',$v->addtime) }}</td>
                <td>
                    <a href="{{url('wechat/resources_download?media_id='.$v->media_id.'&'.'type='.$v->type.'&'.'path='.$v->path)}}">下载素材资源</a>
                </td>
            </tr>
        @endforeach
    </table>
</center>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $('.image').click(function(){
        window.location.href="{{url('wechat/resources_list?type=1')}}";
    })
    $('.voice').click(function(){
        window.location.href="{{url('wechat/resources_list?type=2')}}";
    })
    $('.video').click(function(){
        window.location.href="{{url('wechat/resources_list?type=3')}}";
    })
    $('.thumb').click(function(){
        window.location.href="{{url('wechat/resources_list?type=4')}}";
    })
</script>