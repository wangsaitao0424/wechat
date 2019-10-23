<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function course_add()
    {
        return view('Course.courseAdd');
    }
}
