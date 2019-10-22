<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Openid extends Model
{
    protected $table = 'openid';
    public 	  $timestamps = false;
    protected $fillable = ['uid','openid','subscribe'];

    /**
     * 模型的连接名称
     *
     * @var string
     */
    protected $connection = 'mysql_wx';
}
