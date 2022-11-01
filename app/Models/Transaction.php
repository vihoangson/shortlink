<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// $k = \App\Models\Transaction::find(1029);$k->delete();
class Transaction extends Model {

    use HasFactory;

    protected $fillable = ['value', 'desc'];
    protected $appends = ['value_formated'];
    public    $user_id_from;
    public    $user_id_to;

    protected function getCreatedAtAttribute($date) {
        preg_match('/^(.+)T(.{0,8})/', $date, $match);

        return Carbon::createFromFormat('Y-m-d H:i:s', $match[1] . ' ' . $match[2])
                     ->format('Y-m-d H:i:s');
    }

    protected function getUpdatedAtAttribute($date) {
        preg_match('/^(.+)T(.{0,8})/', $date, $match);

        return Carbon::createFromFormat('Y-m-d H:i:s', $match[1] . ' ' . $match[2])
                     ->format('Y-m-d H:i:s');
    }
    protected function getValueFormatedAttribute($date) {
        return number_format($this->value, 0).' VNĐ';
    }
}
