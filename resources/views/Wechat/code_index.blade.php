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
        <button>微信授权登录</button>
    </center>
</body>
<script src="/js/jq.js"></script>
<script>
    $('button').on('click',function(){
        location.href="{{url(env('APP_URL').'/wecaht/login_code')}}";
    })
</script>
</html>