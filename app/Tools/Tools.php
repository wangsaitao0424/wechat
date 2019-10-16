<?php
namespace APP\Tools;

use Illuminate\Support\Facades\Cache;

Class Tools{
    /**
     * 获取access_token
     * @return mixed
     */
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

    /**
     * 根据openid获取用户的基本新
     * @param $openid
     * @return mixed
     */
    public function get_wechat_user($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->access_token().'&openid='.$openid.'&lang=zh_CN';
        $re = file_get_contents($url);
        $result = json_decode($re,1);
        return $result;
    }

    /**
     * curl post传
     * @param $url
     * @param $data
     * @return mixed
     */
    public function curl_post($url,$data)
    {
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);

        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * curl get传
     * @param $url
     * @return mixed
     */
    public function curl_get($url)
    {
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    /**
     * 获取标签
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag_list()
    {
        $url='https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->access_token();
        $re=$this->curl_get($url);
        $result=json_decode($re,1);
        return $result;
    }

    /**
     * 微信素材专用 post
     * @param $url
     * @param $path
     * @return mixed
     */
    public function wechat_curl_file($url,$path)
    {
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($curl,CURLOPT_POST,true);
        $data=[
            'media'=>new \CURLFile(realpath($path)),
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);

        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}