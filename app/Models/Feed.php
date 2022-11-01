<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    protected $appends = ['url_img'];
    protected function getUrlImgAttribute($data){
        return Upload::find((int)$this->img_cover);
    }
}
