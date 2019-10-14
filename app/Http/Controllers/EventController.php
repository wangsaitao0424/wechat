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
        $info=file_get_contents("php://input");
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),$info,FILE_APPEND);
        $xml_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr=(array)$xml_obj;
        dd($xml_arr);
    }
}
