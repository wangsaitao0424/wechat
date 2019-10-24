<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function course()
    {
        $redirect_uri=env('APP_URL').'/wecaht/code';
//        dd($redirect_uri);
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.urlencode($redirect_uri) .'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//        dd($url);
        header('Location:'.$url);
        dd(11);
    }
    public function course_add()
    {
        return view('Course.courseAdd');
    }
    public function course_do(Request $request)
    {
        $req=$request->all();
    }
}
