<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Course;
class CourseController extends Controller
{
    public function course()
    {
        $redirect_uri=env('APP_URL').'/wecaht/code';
//        dd($redirect_uri);
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.urlencode($redirect_uri) .'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//        dd($url);
        header('Location:'.$url);
    }
    public function course_add()
    {
        return view('Course.courseAdd');
    }
    public function course_do(Request $request)
    {
        $uid=$request->session()->get('uid');
//        dd($uid);
        $req=$request->all();
        $course=Course::create([
            'uid'=>$uid,
            'lesson_one'=>$req['lesson_one'],
            'lesson_two'=>$req['lesson_two'],
            'lesson_three'=>$req['lesson_three'],
            'lesson_four'=>$req['lesson_four'],
        ]);
        return redirect('../../../../../../');
    }
}
