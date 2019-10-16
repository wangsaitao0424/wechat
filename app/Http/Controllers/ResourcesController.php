<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class ResourcesController extends Controller
{
    public $tools;
    public $request;
    public function __construct(Tools $tools,request $request)
    {
        $this->tools=$tools;
        $this->request=$request;
    }

    /**
     * 微信素材上传
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resources_add()
    {
        return view('Resources.resources_add');
    }
    public function resources_do()
    {
        $type=$this->request->all();
        $file_obj=$this->request->file('wechat_resouces');
        $file_exe=$file_obj->getClientOriginalExtension();
        $name_file=time().rand(1000,9999).'.'.$file_exe;
//        echo $name_file;die;
        $path=$this->request->file('wechat_resouces')->storeAs('wechat/'.$type['type'],$name_file);
//        dd($path);
        $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->tools->access_token().'&type='.$type['type'].'';
        $re=$this->tools->wechat_curl_file($url,storage_path('app/public/'.$path));
        $result=json_decode($re,1);
        dd($result);
        //        dd($path);
    }
}
