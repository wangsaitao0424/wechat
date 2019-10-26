<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Tools\Tools;
use App\Model\Course;
use App\Model\Sign;
use DB;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
//            \Log::Info(1111);
//            $tools = new Tools();
//            $user_url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$tools->access_token().'&next_openid=';
//            $openid_info = file_get_contents($user_url);
//            $user_result = json_decode($openid_info,1);
//            foreach($user_result['data']['openid'] as $v){
//                $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$tools->access_token().'&openid='.$v.'&lang=zh_CN';
//                $user_re = file_get_contents($url);
//                $user_info = json_decode($user_re,1);
//                $db_user = DB::connection('mysql_wx')->table('user')->where(['name'=>$user_info['nickname']])->first();
//                if(empty($db_user)){
//                    DB::connection('mysql_wx')->table('user')->insert([[
//                        'name'=>$user_info['nickname'],
//                        'u_time'=>time(),
//                    ]]);
//                    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->access_token();
//                    //选课
//                    $data = [
//                        'touser'=>$v,
//                        'template_id'=>'leKP65ggJwCK4SspkiRXqyZIdrlxY-48ZVWmeD03OTs',
//                        'data'=>[
//                            'name'=>[
//                                'value'=>$user_info['nickname'],
//                                'color'=>''
//                            ],
//                            'lesson_one'=>[
//                                'value'=>'未选课程',
//                                'color'=>''
//                            ],
//                            'lesson_two'=>[
//                                'value'=>'未选课程',
//                                'color'=>''
//                            ],
//                            'lesson_three'=>[
//                                'value'=>'未选课程',
//                                'color'=>''
//                            ],
//                            'lesson_four'=>[
//                                'value'=>'未选课程',
//                                'color'=>''
//                            ]
//                        ]
//                    ];
//                    $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//                }else{
//                    $course=Course::where(['id'=>$db_user->uid])->first();
//                    if(isset($course)) {
//                        $lesson_one = "";
//                        if ($course['lesson_one'] == 1) {
//                            $lesson_one = "php";
//                        } elseif ($course['lesson_one'] == 2) {
//                            $lesson_one = "语文";
//                        } elseif ($course['lesson_one'] == 3) {
//                            $lesson_one = "英语";
//                        } elseif ($course['lesson_one'] == 4) {
//                            $lesson_one = "数学";
//                        }
//                        $lesson_two = "";
//                        if ($course['lesson_two'] == 1) {
//                            $lesson_two = "php";
//                        } elseif ($course['lesson_two'] == 2) {
//                            $lesson_two = "语文";
//                        } elseif ($course['lesson_two'] == 3) {
//                            $lesson_two = "英语";
//                        } elseif ($course['lesson_two'] == 4) {
//                            $lesson_two = "数学";
//                        }
//                        $lesson_three = "";
//                        if ($course['lesson_three'] == 1) {
//                            $lesson_three = "php";
//                        } elseif ($course['lesson_three'] == 2) {
//                            $lesson_three = "语文";
//                        } elseif ($course['lesson_three'] == 3) {
//                            $lesson_three = "英语";
//                        } elseif ($course['lesson_three'] == 4) {
//                            $lesson_three = "数学";
//                        }
//                        $lesson_four = "";
//                        if ($course['lesson_four'] == 1) {
//                            $lesson_four = "php";
//                        } elseif ($course['lesson_four'] == 2) {
//                            $lesson_four = "语文";
//                        } elseif ($course['lesson_four'] == 3) {
//                            $lesson_four = "英语";
//                        } elseif ($course['lesson_four'] == 4) {
//                            $lesson_four = "数学";
//                        }
//                        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$tools->access_token();
//                        $data = [
//                            'touser'=>$v,
//                            'template_id'=>'leKP65ggJwCK4SspkiRXqyZIdrlxY-48ZVWmeD03OTs',
//                            'data'=>[
//                                'name'=>[
//                                    'value'=>$user_info['nickname'],
//                                    'color'=>''
//                                ],
//                                'lesson_one'=>[
//                                    'value'=>$lesson_one,
//                                    'color'=>''
//                                ],
//                                'lesson_two'=>[
//                                    'value'=>$lesson_two,
//                                    'color'=>''
//                                ],
//                                'lesson_three'=>[
//                                    'value'=>$lesson_three,
//                                    'color'=>''
//                                ],
//                                'lesson_four'=>[
//                                    'value'=>$lesson_four,
//                                    'color'=>''
//                                ]
//                            ]
//                        ];
//                        $tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//                    }
//                }
//            }
        })->dailyAt("20:00");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
