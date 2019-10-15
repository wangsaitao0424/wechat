<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
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
        dd($info);
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents(storage_path('logs/wechat'.date('Y-m-d').'.log'),$info,FILE_APPEND);//  追加
//        die();
        $xml_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);//解析xml 后面的两个参数是死的
        $xml_arr=(array)$xml_obj;//强行转化成数组
        dd($xml_arr);
    }
}
