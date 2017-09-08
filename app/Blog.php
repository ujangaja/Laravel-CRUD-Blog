<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';//ini hanya untuk menegaskan table pada database yang tidak plural jd menggunakan ini
}
