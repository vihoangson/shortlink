<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Point extends Model {
    protected $table = 'points';
    protected $fillable = ['value','desc'];

    const ID_LIST_INCOME   = '6322dd0bd248cc0062a17005';
    const ID_LIST_OUTGOING = '6322dd0feab7d602516d0a40';
    const ID_LIST_COIN     = '632d31a2f2ee9c0016a3f7f8';


}
