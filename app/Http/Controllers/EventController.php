<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Sign;
class EventController extends Controller
{
    public $tools;
    public $request;
    public function __construct(Tools $tools,request $request)
    {
        $this->tools=$tools;
        $this->request=$request;
    }
    public function event()
    {
//        echo $_GET['echostr'];die;
        $info=file_get_contents("php://input"); //接受  拿数据流用
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),"\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),$info,FILE_APPEND);//  追加
//        die();
        $xml_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);//解析xml 后面的两个参数是死的
        $xml_arr=(array)$xml_obj;//强行转化成数组
//        dd($xml_arr);
//        var_dump($xml_arr);
//        关注操作
        if($xml_arr['MsgType']=='event' && $xml_arr['Event']=='subscribe'){
            $nickname=$this->tools->get_wechat_user($xml_arr['FromUserName']);
//            dd($nickname);
            $msg="你好".$nickname['nickname'].",欢迎来到！";
            $sign=Sign::where(['openid'=>$nickname['openid']])->first();
//            dd($sign);
            if(empty($sign)){
                Sign::create([
                    'openid'=>$nickname['openid'],
                    'nickname'=>$nickname['nickname'],
                    'sex'=>$nickname['sex'],
                    'subscribe_time'=>$nickname['subscribe_time']
                ]);
            }
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }
        if($xml_arr['MsgType']=='event' && $xml_arr['Event'] == 'CLICK'){
            //判断是否点的是签到
            if($xml_arr['EventKey'] == 'aaaa'){
                //查库
                $integral_time=Sign::where(['openid'=>$xml_arr['FromUserName']])->first();
//                dd($integral_time);
                //判断库中有没有该用户的信息
                if(empty($integral_time)){
                    //无 添加
                    $nickname=$this->tools->get_wechat_user($xml_arr['FromUserName']);
                    Sign::create([
                        'openid'=>$nickname['openid'],
                        'nickname'=>$nickname['nickname'],
                        'sex'=>$nickname['sex'],
                        'subscribe_time'=>$nickname['subscribe_time']
                    ]);
                }
                $today_time=data('Y-m-d',strtotime('-1',time()));
                dd($today_time);
                $integral_times=$integral_time['integral_time'];
                dd($integral_times);
                if($integral_time['integral_time']){

                }
            }

        }
//        普通消息
        if($xml_arr['MsgType']=='text' && $xml_arr['Content']=="你好"){
            $msg="你好！";
          echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }
        //被动回复发送图片
        if($xml_arr['MsgType']=='text' && $xml_arr['Content']=="图片"){
            $msg="u1d_3ecTK6ivZFZghEqyC8ygkKNV8-rQJPJpWOHomPGenhqHpXLq5iqoWLpp-eNm";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[".$msg."]]></MediaId></Image></xml>";
        }
        if($xml_arr['MsgType']=='text' && $xml_arr['Content']=="语音"){
            $msg="GJttHFschemCg2l6QHj78GZnmYnO5EBpq73NvHpjxZ5Er_ocsVcH80ZXS2VWp3Eh";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[voice]]></MsgType><Voice><MediaId><![CDATA[".$msg."]]></MediaId></Voice></xml>";
        }
    }
}