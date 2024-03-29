<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Tools\Tools;
use DB;
class WechatController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    //生成带参数的二维码视图
    public function qr_lists()
    {
        $list=DB::connection('mysql_wx')->table('user')->get();
        return view('Qr.qrlist',['list'=>$list]);
    }
    public function add_qr(Request $request)
    {
        $uid=$request->all();
//        dd($uid['id']);
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->tools->access_token();
        $data=[
            'expire_seconds'=>604800,
            'action_name'=>'QR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>$uid['id']
                ]
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
        $urls='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($result['ticket']);
        $rq=$this->tools->curl_get($urls);
//        dd($rq);
        $path=$uid['id'].rand(10000,99999).'.jpg';
        Storage::put('wechat/qr/'.$path, $rq);
        DB::connection('mysql_wx')->table('user')->update([
            'qr_url'=>'/storage/wechat/qr/'.$path
        ]);
        return redirect('wechat/qrlist');
    }
    /**
     * 微信授权视图
     */
    public function login()
    {
        return view('Wechat.code_index');
    }
    /**
     * 微信授权
     * 获取code
     */
    public function login_code()
    {
        $redirect_uri=env('APP_URL').'/wecaht/code';
        $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('APPID').'&redirect_uri='.urlencode($redirect_uri) .'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//        dd($url);
        header('Location:'.$url);
//        dd(11);
    }
    /**
     * 登录
     */
    public function code(Request $request)
    {
        $req=$request->all();
//        dd($req);
        //获取access_token
        $re=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('APPID').'&secret='.env('APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
//        dd($re);
        $res=json_decode($re,1);
//        dd($res);
//        获取用户基本信息
        $user=file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid=OPENID&lang=zh_CN');
        $users=json_decode($user,1);
//        查询库
        $user_info=DB::connection('mysql_wx')->table('user_wecaht')->where(['openid'=>$users['openid']])->first();
//        dd($user_info->uid);
        if(!empty($user_info)){
//            存在存session
            $request->session()->put('uid',$user_info->uid);
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
                $request->session()->put('uid',$uid);
                DB::connection('mysql_wx')->commit();
            }else{
                DB::connection('mysql_wx')->rollback();
                dd('有误');
            }
        }
        return redirect('wechat/course_add');
    }
    /**
     * 获取access_token
     * 和用户基本信息
     */
    public function index(Request $request)
    {
        $token=$this->tools->access_token();
//        获取openid
        $openid=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token.'&next_openid=');
        $re=json_decode($openid,1);
//        dd($re);
        $openid_list=[];
        foreach ($re['data']['openid'] as $v)
        {
//            获取用户基本信息
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->access_token().'&openid='.$v.'&lang=zh_CN');
            $res=json_decode($user_info,1);
//            dd($res);
            $openid_list[]=$res;
        }
//        dd($openid_list);
        return view('Wechat.user_list',['list'=>$openid_list,'tag_id'=>$request->all()]);
    }

    /**
     * 公众号调用或第三方平台帮公众号调用对公众号的所有api调用（包括第三方帮其调用）次数进行清零：
     */
    public function clear_api()
    {
//        echo 11;die;
        $url='https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->tools->access_token();
        $data=['appid'=>env('APPID')];
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
        dd($result);
    }

    /**
     *
     */
    public function wechat_carte()
    {
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->tools->access_token();
//        $data=[
//            "button"=>[
//                [
//                    "type"=>"click",
//                    "name"=>"今日歌曲",
//                    "key"=>"V1001_TODAY_MUSIC"
//                ],
//                [
//                        "name"=>"菜单",
//                        "sub_button"=>[
//                        [
//                            "type"=>"view",
//                            "name"=>"搜索",
//                            "url"=>"http://www.soso.com/"
//                        ],
//                        [
//                            "type"=>"click",
//                            "name"=>'赞一下我们',
//                            "key"=>"V1001_GOOD"
//                        ]
//                    ]
//                ]
//            ]
//        ];
        $data=[
            "button"=>[
                [
                    "type"=>"click",
                    "name"=>"积分查询",
                    "key"=>"V1001_TODAY_MUSIC"
                ],
                [
                    'type'=>'click',
                    "name"=>"签到",
                    'key'=>'V1002_SIGN_in'

                ]
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }

    /**
     * jssdk
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function jssdk()
    {
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $_now_=time();
        $appid=env('APPID');
        $nonce_Str=rand(1000,9999).time().'jssdk';
        $jsapi_ticket=$this->tools->jsapi_ticket();
        //ASCII 码从小到大排序
        $ascll='jsapi_ticket='.$jsapi_ticket.'&noncestr='.$nonce_Str.'&timestamp='.$_now_.'&url='.$url.'';
        $signature=sha1($ascll);
        return view('Wechat.jssdk',['appId'=>$appid,'timestamp'=>$_now_,'nonceStr'=>$nonce_Str,'signature'=>$signature]);
    }
}
