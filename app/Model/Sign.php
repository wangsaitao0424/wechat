<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    protected $table = 'wechat_sign';
    public 	  $timestamps = false;
    protected $fillable = ['openid','nickname','sex','subscribe_time'];

    /**
     * 模型的连接名称
     *
     * @var string
     */
    protected $connection = 'mysql_wx';
}
