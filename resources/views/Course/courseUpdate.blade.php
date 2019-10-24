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
        <form action="{{url('wechat/course_update_do')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$course->id}}">
            <table>
                <tr>
                    <td>第一节课</td>
                    <td>
                        <select name="lesson_one" id="">
                            <option value="{{$course->lesson_one}}">@if($course->lesson_one == 1)php@elseif($course->lesson_one == 2)语文@elseif($course->lesson_one == 3)英语@elseif($course->lesson_one == 4)数学@endif</option>
                            <option value="1">php</option>
                            <option value="2">语文</option>
                            <option value="3">英语</option>
                            <option value="4">数学</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>第二节课</td>
                    <td>
                        <select name="lesson_two" id="">
                            <option value="{{$course->lesson_two}}">@if($course->lesson_two == 1)php@elseif($course->lesson_two == 2)语文@elseif($course->lesson_two == 3)英语@elseif($course->lesson_two == 4)数学@endif</option>
                            <option value="1">php</option>
                            <option value="2">语文</option>
                            <option value="3">英语</option>
                            <option value="4">数学</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>第三节课</td>
                    <td>
                        <select name="lesson_three" id="">
                            <option value="{{$course->lesson_three}}">@if($course->lesson_three == 1)php@elseif($course->lesson_three == 2)语文@elseif($course->lesson_three == 3)英语@elseif($course->lesson_three == 4)数学@endif</option>
                            <option value="1">php</option>
                            <option value="2">语文</option>
                            <option value="3">英语</option>
                            <option value="4">数学</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>第四节课</td>
                    <td>
                        <select name="lesson_four" id="">
                            <option value="{{$course->lesson_four}}">@if($course->lesson_four == 1)php@elseif($course->lesson_four == 2)语文@elseif($course->lesson_four == 3)英语@elseif($course->lesson_four == 4)数学@endif</option>
                            <option value="1">php</option>
                            <option value="2">语文</option>
                            <option value="3">英语</option>
                            <option value="4">数学</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="提交"></td>
                    <td></td>
                </tr>
            </table>
        </form>
    </center>
</body>
</html>