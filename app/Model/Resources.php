<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    protected $table = 'resources';
    public 	  $timestamps = false;
    protected $fillable = ['media_id','type','path','addtime'];

    /**
     * 模型的连接名称
     *
     * @var string
     */
    protected $connection = 'mysql_wx';
}
