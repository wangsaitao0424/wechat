<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Resources;
use Illuminate\Support\Facades\Storage;
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
        $type=$this->request->all();//接受type
        $type_arr = ['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4]; //数据库
        if(!$this->request->hasFile('wechat_resouces')){
            dd('没有文件');
        }
        $file_obj=$this->request->file('wechat_resouces'); //接受文件名字
        $file_exe=$file_obj->getClientOriginalExtension(); //后缀名
        $name_file=time().rand(1000,9999).'.'.$file_exe; //重命名
//        echo $name_file;die;
        $path=$this->request->file('wechat_resouces')->storeAs('wechat/'.$type['type'],$name_file); //路径
//        dd($path);
        $data = [
            'media'=>new \CURLFile(storage_path('app/public/'.$path)), //json 字符串
        ];
        //视频的data
        if($type['type']=='video'){
            $data['description']=[
                'title'=>'标题',
                'introduction'=>'描述'
            ];
            $data['description']=json_encode($data['description'],JSON_UNESCAPED_UNICODE);
        }
//        dd($data);
        $url='https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->tools->access_token().'&type='.$type['type'].'';
//        dd($url);
        $re=$this->tools->wechat_curl_file($url,$data);
        $result=json_decode($re,1);
//        dd($result);
        //数据库添加
        if(!isset($result['errcode'])){
            Resources::create([
                'media_id'=>$result['media_id'],
                'type'=>$type_arr[$type['type']],
                'path'=>'/storage/'.$path,
                'addtime'=>time()
            ]);
        }
        dd($result);
        echo "ok";
        //        dd($path);
    }

    /**
     * 素材展示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resources_list()
    {
        $type=$this->request->all();
//        var_dump($type);
        if($type){
            $list=Resources::where(['type'=>$type])->get();
        }else{
            $list=Resources::where(['type'=>1])->get();
        }
        return view('Resources.resources_list',['res'=>$list]);
//        dd($list);
    }

    /**
     * 素材下载
     */
    public function resources_download()
    {
        $media_id=$this->request->all();
//        $type_arr = [1=>'image',2=>'voice',3=>'video',4=>'thumb'];
        $names=strchr($media_id['path'],'.');
        $path_name=time().rand(1000,9999).$names;
        $url='https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$this->tools->access_token();
        $data=[
          'media_id'=>$media_id['media_id'],
        ];
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
        //设置超时参数
        $opts=array(
          'http'=>array(
              "method"=>'GET',
              'timeout'=>3
          ),
        );
        //创建数据流上下文
        $context=stream_context_create($opts);
        //创建数据流上下文
        $file_source=file_get_contents($result['down_url'],false,$context);
        $path=Storage::put('wechat/'.$media_id['type'].'/'.$path_name,$file_source);
        dd($path);
    }
}
