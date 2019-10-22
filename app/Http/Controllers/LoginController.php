<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use DB;
class LoginController extends Controller
{
    public $tools;
    public $requers;
    public function __construct(Tools $tools,Request $request)
    {
        $this->tools=$tools;
        $this->requers=$request;

    }
    /**
     * 周考登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('Login.index');
    }

    /**
     * 获取code
     */
    public function login_do()
    {
        $redirect_uri=env('APP_URL').urlencode('/week_test/login_code');
//        dd($redirect_uri);
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);
    }

    /**
     * openid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function login_code()
    {
        $req=$this->requers->all();
//        dd($req);
        $url=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
//        dd($url);
        $urls=json_decode($url,1);
//        dd($urls);
        $user=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$urls['access_token'].'&openid=OPENID&lang=zh_CN');
//        dd($user);
        $users=json_decode($user,1);
        $user_info=DB::connection('mysql_wx')->table('user_wecaht')->where(['openid'=>$users['openid']])->first();
//        dd($user_info);
        if(!empty($user_info)){
//            存在存session
            $this->requers->session()->put('uid',$user_info->uid);
        }else{
//            不存在  存库中
            DB::connection('mysql_wx')->beginTransaction(); //开启事务
            $uid= DB::connection('mysql_wx')->table('user')->insertGetId([
                'name'=>$users['nickname'],
                'password'=>'',
                'u_time'=>time()
            ]);
            $insert_result=DB::connection('mysql_wx')->table('user_wecaht')->insert([
                'uid'=>$uid,
                'openid'=>$users['openid'],
            ]);
            if($uid && $insert_result){
                $this->requers->session()->put('uid',$user_info['uid']);
                DB::connection('mysql_wx')->commit();
            }else{
                DB::connection('mysql_wx')->rollback();
                dd('有误');
            }
        }
        $ur='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->access_token().'&next_openid=';
        $use=$this->tools->curl_get($ur);
//        dd($use);
        $us=json_decode($use,1);
//        dd($us['data']['openid']);
        return view('Login.user',['users'=>$us['data']['openid']]);
    }

    /**
     *
     * 发送模板消息
     */
    public function login_news()
    {
        $req=$this->requers->all();
//        dd($req);
        $url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->access_token();
        $data=[
            'touser'=>$req['openid'],
            'template_id'=>'gG4IYzkcUbEp0vq5PZWUmENd6HWqGeAaZpWeEE1FlRI',
            'data'=>[
                'first'=>[
                    'value'=>'恭喜你'
                ]
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($re);
    }
}