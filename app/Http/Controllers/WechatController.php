<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class WechatController extends Controller
{
    /**
     * 获取access_token
     */
    public function index()
    {
        $token=$this->access_token();
        $openid=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&next_openid=');
        $re=json_decode($openid,1);
//        dd($re);
        $openid_list=[];
        foreach ($re['data']['openid'] as $v)
        {
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token().'&openid='.$v.'&lang=zh_CN');
            $res=json_decode($user_info,1);
//            dd($res);
            $openid_list[]=$res;
        }
//        dd($openid_list);
        return view('Wechat.user_list',['list'=>$openid_list]);
    }
    public function access_token()
    {
    	$key='wechat_access_token';
//    	dd($key);
//        判断是否为空
    	if(Cache::has($key)){
//    	    有，取出来
            $wechat_assess_token=Cache::get($key);
        }else{
//    	    没有，从微信获取
            $file=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('APPID').'&secret='.env('APPSECRET'));
            $re=json_decode($file,1);
//            存
            Cache::put($key,$re['access_token'],$re['expires_in']);
            $wechat_assess_token=$re['access_token'];
        }
        return $wechat_assess_token;
    }

}
