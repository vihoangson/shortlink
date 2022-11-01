<?php

namespace App\Services;

use App\Models\Point;

class PointService {

    //App\Services\PointService::addPoint();
    public static function addPoint(int $v,string $d) {
        $point = Point::create(["value" => $v, "desc" => $d]);
        return $point;
    }

    //App\Services\PointService::getTotalPoint();
    public static function getTotalPoint() {
        $point = Point::all('value');
        $sum = 0;
        foreach ($point as $p ){
            $sum +=$p->value;
        }
        return $sum;
    }

    public static function getListPoint() {
        $p = Point::all();
        return $p->sort(function ($a,$b){return $a->id < $b->id;});
    }
}
