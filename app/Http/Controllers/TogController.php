<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class TogController extends Controller
{
    public $tools;
    public $request;
    public function __construct(Tools $tools,request $request)
    {
        $this->tools=$tools;
        $this->request=$request;
    }

    /**
     * 标签列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tog_list()
    {
       $result=$this->tools->tag_list();
//       dd($result);
        return view('Tog.tog_list',['data'=>$result]);
    }

    /**
     * 标签添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add_tog()
    {
        return view('Tog.do_tog');
    }

    /**
     * 添加执行
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function do_tog()
    {
        $req=$this->request->all();
//        dd($req);
        $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->tools->access_token();
        $data=[
            'tag'=>[
                'name'=>$req['tag_name']
            ]
        ];
//        JSON_UNESCAPED_UNICODE  不转化中文
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
//        dd($result);
        if($result){
           return redirect('wechat/tog_list');
        }
    }

    /**
     * 修改
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update_tog()
    {
        $req=$this->request->all();
        return view('Tog.update_tog',['tag_name'=>$req['tag_name'],'tag_id'=>$req['tag_id']]);
    }
    /**
     * 修改
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function do_update_tog()
    {
        $req=$this->request->all();
        $url='https://api.weixin.qq.com/cgi-bin/tags/update?access_token='.$this->tools->access_token();
        $data=[
            'tag'=>[
                'id'=>$req['tag_id'],
                'name'=>$req['tag_name']
            ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//        dd($re);
        return redirect('wechat/tog_list');
    }

    /**
     * 删除
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del_tog()
    {
        $req=$this->request->all();
        $url='https://api.weixin.qq.com/cgi-bin/tags/delete?access_token='.$this->tools->access_token();
        $data=[
          'tag'=>[
              'id'=>$req['tag_id']
          ]
        ];
        $re=$this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        return redirect('wechat/tog_list');
    }

    /**
     * 给用户打标签
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add_user()
    {
        $req=$this->request->all();
        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->access_token();
        $data=[
            'tagid'=>$req['tag_id'],
            'openid_list'=>$req['openid_list']
        ];
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
//        dd($result);
        return redirect('wechat/tog_list');
    }

    /**
     *粉丝下的标签
     *
     */
    public function user_tag()
    {
        $req=$this->request->all();
//        dd($req);
        $url='https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$this->tools->access_token();
        $data=[
            'openid'=>$req['openid']
        ];
//        dd($data);
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
//        dd($result);
        $tag=$this->tools->tag_list();
//        dd($tag);
        foreach ($result['tagid_list'] as $v){
            foreach ($tag['tags'] as $value){
                if($v==$value['id']){
                    echo $value['name'].'<br>';
                }
            }
        }
    }

    /**
     * 查看标签下粉丝
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag_user()
    {
        $req=$this->request->all();
//        dd($req);
        $url='https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->access_token();
        $data=[
            'tagid'=>$req['tag_id'],
            'next_openid'=>''
        ];
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
//        dd($result);
//        dd($result['data']['openid']);
        return view('Tog.tag_user',['list'=>$result,'tag_id'=>$req]);
    }

    /**
     * 批量取消用户标签
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function on_user_tag()
    {
        $req=$this->request->all();
//        dd($req);
        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token='.$this->tools->access_token();
        $data=[
            'openid_list'=>$req['openid_list'],
            'tagid'=>$req['tag_id']
        ];
        $re=$this->tools->curl_post($url,json_encode($data));
        $result=json_decode($re,1);
        return redirect('wechat/tog_list');
    }
}
