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
        <form action="{{url('wechat/create_menu')}}" method="post">
            @csrf
            <br/>
           类型： <select name="type" id="">
                    <option value="1">1</option>{{--1为没有第二级菜单的一级菜单--}}
                    <option value="2">2</option>{{--2为第二级菜单--}}
                    <option value="3">3</option> {{--3为有二级菜单的一级菜单--}}
                </select>
            <br><br>

            <div class="name1">
                一级菜单：<input type="text" name="name_one"><br><br>
            </div>

            <div class="name2" style="display: none">
                一级菜单：<select name="pid" id="">
                            @foreach($pid as $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select><br>
                二级菜单：<input type="text" name="name_two">
            </div>
            <br>

            <div class="event">
            事件: <select name="event" id="">
                        <option value="click">click</option>
                        <option value="view">view</option>
                   </select>
                    <br><br>
            event_key：<input type="text" name="event_key">
            </div>
            <br><br>
            <input type="submit" value="提交">
        </form>
    </center>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $("select[name=type]").change(function(){
        var type_val=this.value;
        if(type_val==2){
            $('.name1').hide();
            $('.name2').show();
            $('.event').show();
        }else if(type_val==3){
            $('.name1').show();
            $('.name2').hide();
            $('.event').hide();
        }else{
            $('.name1').show();
            $('.name2').hide();
            $('.event').show();
        }
    })
</script>