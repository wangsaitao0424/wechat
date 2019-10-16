<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>微信临时素材上传</title>
</head>
<body>
    <center>
        <form action="{{url('wechat/resources_do')}}" method="post" enctype="multipart/form-data">
            @csrf
            类型：<select name="type" id="">
                <option value="image">图片</option>
                <option value="voice">音频</option>
                <option value="video">视频</option>
                <option value="thumb">缩约图</option>
            </select>
            <br><br>
            <input type="file" name="wechat_resouces"><br><br>
            <input type="submit" value="上传">
        </form>
    </center>
</body>
</html>