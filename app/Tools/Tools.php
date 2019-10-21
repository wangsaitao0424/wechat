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
//       $cache = Cache::forget($key);
//       dd($cache);
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
    public function wechat_curl_file($url,$data)
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
    //无限极分类
    function createTree($data,$parent_id=0,$level=1)
    {
        //1、定义一个容器  static 可以一直存在，不被循环掉
        static $new_arr=[];
        // dd($data);
        //2、遍历数据一条一条的找
        foreach ($data as $key => $value) {
            // dd($value);
            //3、先找parent_id=0
            if($value['pid']==$parent_id){
                //4、找到后放入容器中
                $value['level']=$level;
                $new_arr[]=$value;
//                dd($value['id']);
                //5、调用程序自身递归找子级parent_id=cat_id
                $this->createTree($data,$value['id'],$level+1);
                // $new_arr = array_merge(createTree($data,$value['cat_id'],$lev+1));
            }
        }
        return $new_arr;
    }
}