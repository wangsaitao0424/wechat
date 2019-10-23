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
        <form action="{{url('wechat/course_do')}}" method="post">
            @csrf
            <table>
                <tr>
                    <td>第一节课</td>
                    <td>
                        <select name="lesson_one" id="">
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