<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Menu;
class MenuController extends Controller
{
    public $tools;
    public $request;
    public function __construct(Tools $tools,Request $request)
    {
        $this->tools=$tools;
        $this->request=$request;
    }

    /**
     * 自定义菜单视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_menu()
    {
        $pid=Menu::where(['pid'=>0,'type'=>3])->get();
        return view('Menu.addMenu',['pid'=>$pid]);
    }

    /**
     * 添加执行
     */
    public function create_menu()
    {
        $req=$this->request->all();
//        dd($req);
        if($req['type']==1){
            $count_one=Menu::where('type','!=','2')->count();
            if($count_one >= 3){
                dd('一级菜单超限');
            }
            Menu::create([
               'name'=>$req['name_one'],
                'type'=>$req['type'],
                'event'=>$req['event'],
                'event_key'=>$req['event_key'],
                'pid'=>0
            ]);
        }elseif($req['type']==2){
            $count_two=Menu::where(['pid'=>$req['pid']])->count();
            if($count_two >= 5){
                dd('该二级菜单超限');
            }
            Menu::create([
                'name'=>$req['name_two'],
                'type'=>$req['type'],
                'event'=>$req['event'],
                'event_key'=>$req['event_key'],
                'pid'=>$req['pid']
            ]);
        }elseif($req['type']==3){
            $count_one=Menu::where('type','!=','2')->count();
            if($count_one >= 3){
                dd('一级菜单超限');
            }
            Menu::create([
                'name'=>$req['name_one'],
                'type'=>$req['type'],
                'event'=>'',
                'event_key'=>'',
                'pid'=>0
            ]);
        }
//        dd("提交成功");
        return redirect('wecaht/wechat_menu');
    }

    /**
     * 加载菜单
     */
    public function wechat_menu()
    {
        $menu=Menu::where(['pid'=>0])->get();
//        dd($menu);
        $data=[];
        foreach ($menu as $v)
        {
          if($v['type'] == 1)
          {
              //没有二级菜单的一级菜单
              if($v['event'] == 'click')
              {
                  $data['button'][]=[
                      "type"=>"click",
                      "name"=>$v['name'],
                      "key"=>$v['event_key']
                  ];

              }elseif($v['event'] == 'view'){
                  $data['button'][]=[
                      "type"=>"view",
                      "name"=>$v['name'],
                      "key"=>$v['event_key']
                  ];
              }
          }elseif($v['type'] == 3){
              //有二级菜单的一级菜单
              //根据三级菜单的id查二级菜单
              $menu_two=Menu::where(['pid'=>$v['id']])->get();
              $menu_arr=[];
              $menu_arr['name']=$v['name'];
              foreach($menu_two as $value)
              {
                  if($value['event'] == 'click')
                  {
                      $menu_arr['sub_button'][]=[
                          "type"=>"click",
                          "name"=>$value['name'],
                          "key"=>$value['event_key']
                      ];
                  }elseif($value['event'] == 'view'){
                      $menu_arr['sub_button'][]=[
                          "type"=>"view",
                          "name"=>$value['name'],
                          "url"=>$value['event_key']
                      ];
                  }
              }
              $data['button'][]=$menu_arr;
          }
        }
//        echo "<pre>";
//        print_r($data);die;
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->tools->access_token();
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }
}
