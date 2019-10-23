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
        <script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
        <script>
            wx.config({
                debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                appId: '{{$appId}}', // 必填，公众号的唯一标识
                timestamp: '{{$timestamp}}', // 必填，生成签名的时间戳
                nonceStr: '{{$nonceStr}}', // 必填，生成签名的随机串
                signature: '{{$signature}}',// 必填，签名
                jsApiList: ['getLocation'] // 必填，需要使用的JS接口列表
            });
            wx.ready(function(){
                // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
                wx.getNetworkType({
                    success: function (res) {
                        var networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
                    }
                });
            });
        </script>
    </center>
</body>
</html>