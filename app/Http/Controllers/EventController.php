<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
use App\Model\Sign;
use App\Model\Openid;
use App\Model\Course;
use DB;
class EventController extends Controller
{
    public $tools;
    public $request;

    public function __construct(Tools $tools, request $request)
    {
        $this->tools = $tools;
        $this->request = $request;
    }

    public function event()
    {
//        echo $_GET['echostr'];die;
        $info = file_get_contents("php://input"); //接受  拿数据流用
        file_put_contents(storage_path('logs/wechat/' . date('Y-m-d') . '.log'), "\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n", FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/' . date('Y-m-d') . '.log'), $info, FILE_APPEND);//  追加
        $xml_obj = simplexml_load_string($info, 'SimpleXMLElement', LIBXML_NOCDATA);//解析xml 后面的两个参数是死的
        $xml_arr = (array)$xml_obj;//强行转化成数组
//        关注操作
        if ($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe') {
            //判断openid表是否有当前openid
//            $openid_info = Openid::where(['openid' => $xml_arr['FromUserName']])->first();
//            if (empty($openid_info)) {
//                //首次关注
//                if (isset($xml_arr['Ticket'])) {
//                    //带参数
//                    $share_code = explode('_', $xml_arr['EventKey'])[1];
//                    Openid::insert([
//                        'uid' => $share_code,
//                        'openid' => $xml_arr['FromUserName'],
//                        'subscribe' => 1
//                    ]);
//                    DB::connection('mysql_wx')->table('user')->where(['uid' => $share_code])->increment('qr_count', 1); //加业绩
//                } else {
//                    //普通关注
//                    Openid::insert([
//                        'uid' => 0,
//                        'openid' => $xml_arr['FromUserName'],
//                        'subscribe' => 1
//                    ]);
//                }
//            }
            $nickname = $this->tools->get_wechat_user($xml_arr['FromUserName']);
//            dd($nickname);
            $sign = Sign::where(['openid' => $nickname['openid']])->first();
//            dd($sign);
            if (empty($sign)) {
                Sign::create([
                    'openid' => $nickname['openid'],
                    'nickname' => $nickname['nickname'],
                    'sex' => $nickname['sex'],
                    'subscribe_time' => $nickname['subscribe_time']
                ]);
                $msg = "您好" . $nickname['nickname'] . "帅哥，\n欢迎回到gh_82d57fc0241a公众号\n发送图文，展示一条图文消息\n发送城市名+天气，回复对应城市一周天气气温";
                echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
            }else{
                $msg = "您好" . $nickname['nickname'] . "帅哥，\n欢迎关注gh_82d57fc0241a公众号";
                echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
            }

        }
        //签到
        if ($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'CLICK') {
            //判断是否点的是签到
            if ($xml_arr['EventKey'] == 'aaaa') {
                //查库
                $integral_time = Sign::where(['openid' => $xml_arr['FromUserName']])->first();
//                dd(empty($integral_time));
                //判断库中有没有该用户的信息
                if (empty($integral_time)) {
                    //无 添加
//                    dd(11);
                    $nickname = $this->tools->get_wechat_user($xml_arr['FromUserName']);
                    Sign::create([
                        'openid' => $nickname['openid'],
                        'nickname' => $nickname['nickname'],
                        'sex' => $nickname['sex'],
                        'subscribe_time' => $nickname['subscribe_time']
                    ]);
                }
//                $ti=strtotime("-2 days");
//                dd($ti);
                //今天时间
                $today_time = date('Y-m-d', time());
                //昨天时间
                $yesterday_time = date('Y-m-d', strtotime("-1 days"));
//                dd($yesterday_time);
                //签到的时间
                $integral_times = date('Y-m-d', $integral_time['integral_time']);
                //今日已签到
                if ($integral_times == $today_time) {
                    $msg = '今日已签到 ';
                    echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
                } else {
                    //今日未签到
                    //连续签到
                    if ($yesterday_time == $integral_times) {
                        //超过5天按第一次计算
                        if ($integral_time['count'] >= 5) {
                            Sign::where(['openid' => $xml_arr['FromUserName']])->update([
                                'integral' => $integral_time['integral'] + 5,
                                'integral_time' => time(),
                                'count' => 1
                            ]);
                        } else {
                            //没超过5天
                            Sign::where(['openid' => $xml_arr['FromUserName']])->update([
                                'integral' => $integral_time['integral'] + ($integral_time['count'] + 1) * 5,
                                'integral_time' => time(),
                                'count' => $integral_time['count'] + 1
                            ]);
                        }
                    } else {
                        //没连续签到
                        Sign::where(['openid' => $xml_arr['FromUserName']])->update([
                            'integral' => $integral_time['integral'] + 5,
                            'integral_time' => time(),
                            'count' => 1
                        ]);
                    }
                    $msg = '签到成功';
                    echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
                }
            } elseif ($xml_arr['EventKey'] == 'bbbb') {
                //查询总积分
                $integral_time = Sign::where(['openid' => $xml_arr['FromUserName']])->first();
                $msg = '你的总积分为：' . $integral_time['integral'] . '分';
                echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
            } elseif ($xml_arr['EventKey'] == '6732') {
                //课程查询
                $nickname = $this->tools->get_wechat_user($xml_arr['FromUserName']);
                $uid = DB::connection('mysql_wx')->table('user')->where(['name' => $nickname['nickname']])->first();
                $course = Course::where(['id' => $uid->uid])->first();
                if (isset($course)) {
                    $lesson_one = "";
                    if ($course['lesson_one'] == 1) {
                        $lesson_one = "php";
                    } elseif ($course['lesson_one'] == 2) {
                        $lesson_one = "语文";
                    } elseif ($course['lesson_one'] == 3) {
                        $lesson_one = "英语";
                    } elseif ($course['lesson_one'] == 4) {
                        $lesson_one = "数学";
                    }
                    $lesson_two = "";
                    if ($course['lesson_two'] == 1) {
                        $lesson_two = "php";
                    } elseif ($course['lesson_two'] == 2) {
                        $lesson_two = "语文";
                    } elseif ($course['lesson_two'] == 3) {
                        $lesson_two = "英语";
                    } elseif ($course['lesson_two'] == 4) {
                        $lesson_two = "数学";
                    }
                    $lesson_three = "";
                    if ($course['lesson_three'] == 1) {
                        $lesson_three = "php";
                    } elseif ($course['lesson_three'] == 2) {
                        $lesson_three = "语文";
                    } elseif ($course['lesson_three'] == 3) {
                        $lesson_three = "英语";
                    } elseif ($course['lesson_three'] == 4) {
                        $lesson_three = "数学";
                    }
                    $lesson_four = "";
                    if ($course['lesson_four'] == 1) {
                        $lesson_four = "php";
                    } elseif ($course['lesson_four'] == 2) {
                        $lesson_four = "语文";
                    } elseif ($course['lesson_four'] == 3) {
                        $lesson_four = "英语";
                    } elseif ($course['lesson_four'] == 4) {
                        $lesson_four = "数学";
                    }
                    $msg = "你好," . $nickname['nickname'] . "同学,你当前的课程安排如下\n第一节:" . $lesson_one . "\n第二节课:" . $lesson_two . "\n第三节课:" . $lesson_three . "\n第四节课:" . $lesson_four;
                    echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
                } else {
                    $msg = "请先选择课程";
                    echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
                }
            }

        }
        //天气
        $contents=strstr($xml_arr['Content'],'天气');
        if(!empty($contents)){
           $city=file_get_contents('http://api.k780.com/?app=weather.city&appkey='.env('APPKEYS').'&sign='.env('SIGN').'&format=json');
           $ci=json_decode($city,1);
           $names=mb_substr($xml_arr['Content'],0,-2);
//           dd($ci['result']['datas']['1']['citynm']);
            $msgs=[];
           foreach ($ci['result']['datas'] as $k=>$v){
               if($v['citynm'] == $names){
                  $url=file_get_contents('http://api.k780.com/?app=weather.future&weaid='.$v['weaid'].'&appkey='.env('APPKEYS').'&sign='.env('SIGN').'&format=json');
                  $urls=json_decode($url,1);
                   foreach ($urls['result'] as $k=>$v){
                       $msg=$v['days'].",".$v['citynm'].",".$v['week'].",".$v['temperature'].",".$v['weather']."\n";
                       $msgs[]=$msg;
                   }
                   echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msgs['0'].$msgs['1'].$msgs['2'].$msgs['3'].$msgs['4'].$msgs['5'].$msgs['6']. "]]></Content></xml>";die;
               }
           }

        }
//        图文消息
        if ($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == "图文") {
            $title="标题";
            $description="描述";
            $picurl="http://mmbiz.qpic.cn/mmbiz_jpg/BQaPpLPjHiadJ3hBIic3xLE2GbsEcC3u6ZXfadVhUV0I8ts97LpqbIWwVYnxbS7egYib7Uq5ABRCWwa339RlFTMiaA/0?wx_fmt=jpeg";
            $url="https://www.chsi.com.cn/";
            echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>1</ArticleCount><Articles><item><Title><![CDATA[".$title."]]></Title><Description><![CDATA[".$description."]]></Description><PicUrl><![CDATA[".$picurl."]]></PicUrl><Url><![CDATA[".$url."]]></Url></item></Articles></xml>";
        }
//        普通消息
//        if ($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == "你好") {
//            $msg = "你好！";
//            echo "<xml><ToUserName><![CDATA[" . $xml_arr['FromUserName'] . "]]></ToUserName><FromUserName><![CDATA[" . $xml_arr['ToUserName'] . "]]></FromUserName><CreateTime>" . time() . "</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[" . $msg . "]]></Content></xml>";
//        }
        //被动回复发送图片
//        if($xml_arr['MsgType']=='text' && $xml_arr['Content']=="图片"){
//            $msg="u1d_3ecTK6ivZFZghEqyC8ygkKNV8-rQJPJpWOHomPGenhqHpXLq5iqoWLpp-eNm";
//            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[".$msg."]]></MediaId></Image></xml>";
//        }
//        if($xml_arr['MsgType']=='text' && $xml_arr['Content']=="语音"){
//            $msg="GJttHFschemCg2l6QHj78GZnmYnO5EBpq73NvHpjxZ5Er_ocsVcH80ZXS2VWp3Eh";
//        }
        //油价
//        if($xml_arr['MsgType']=='text'){
//            $url = "http://apis.juhe.cn/cnoil/oil_city";
//            $params = array(
//                "key" => env('APPKEY'),//应用APPKEY(应用详细页查询)
//                "dtype" => $xml_arr['Content'],//返回数据的格式,xml或json，默认json
//            );
//            $paramstring = http_build_query($params);
//            $content = $this->tools->juhecurl($url,$paramstring);
//            $result = json_decode($content,true);
//            if($result){
//                if($result['error_code']=='0'){
//                    print_r($result);
//                }else{
//                    echo $result['error_code'].":".$result['reason'];
//                }
//            }else{
//                echo "请求失败";
//            }
//        }
    }
}