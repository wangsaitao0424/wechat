<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    public 	  $timestamps = false;
    protected $fillable = ['uid','lesson_one','lesson_two','lesson_three','lesson_four','count'];

    /**
     * 模型的连接名称
     *
     * @var string
     */
    protected $connection = 'mysql_wx';
}
