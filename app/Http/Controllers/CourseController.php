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
        $uid=Request()->session()->get('uid');
        $cousr=Course::where(['uid'=>$uid])->first();
        if(isset($cousr)){
            return redirect('wechat/course_update');
        }else{
            return view('Course.courseAdd');
        }
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
        return dd('提交成功');
    }
    public function course_update()
    {
        $uid=Request()->session()->get('uid');
        $cousr=Course::where(['uid'=>$uid])->first();
        dd($cousr);
        return view('Course.courseUpdate',['course'=>$cousr]);
    }
    public function course_update_do()
    {
        $req=request()->all();
        Course::where(['id'=>$req['id']])->update([
            'lesson_one'=>$req['lesson_one'],
            'lesson_two'=>$req['lesson_two'],
            'lesson_three'=>$req['lesson_three'],
            'lesson_four'=>$req['lesson_four'],
        ])->increment('count',1);
        dd('修改成功');
    }
}
