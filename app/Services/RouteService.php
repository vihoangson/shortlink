<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RouteService {

    public static function content() {

        $keys         = Redis::keys('MESSAGE_CONTENT_12775_*');
        $m            = collect();
        $mapping_user = config('app.mapping_user');
        $total = sizeof($keys);
        foreach ($keys as $k => $key) {
            $string = \Illuminate\Support\Facades\Redis::get($key);
            $m      = self::convert($string, $mapping_user);
            Redis::set($key, $m);
            Log::info($k .'/'.$total);
        }

    }

    public static function convert($m, $mapping_user) {

        if (preg_match('/\[rp aid=([0-9]+) to=([0-9]+)-([0-9]+)\]/', $m, $match)) {

            if((int)$match[2] > 4299) return ;

            $id_mgs = Redis::get('MSGIDCWRAW_' . $match[3]);
            preg_match('/INFO_([0-9]+)_([0-9]+)_([0-9]+)/', $id_mgs, $matchid);
            $m = (str_replace('' . $match[1], '' . $mapping_user[$match[1]]['id_sns'], $m));
            $m = (str_replace($match[3], $matchid[3], $m));
            $m = preg_replace('/\[rp aid=([0-9]+) to=([0-9]+)-([0-9]+)\]/', '[reply mid:$3 to:$1] ', $m);

        }
        if (preg_match('/\[qt]\[qtmeta aid=([0-9]+) time=([0-9]+)\]/', $m, $match)) {
            if ((int) $match[1] > 1000) {
                if (isset($mapping_user[$match[1]])) {
                    $m = (str_replace('' . $match[1], '' . $mapping_user[$match[1]]['id_sns'], $m));
                }
            }
            $m = preg_replace('/\[qt]\[qtmeta aid=([0-9]+) time=([0-9]+)\]/', '[quote uid:$1 time:$2] ', $m);
            $m = preg_replace('/\[\/qt]/', '[/quote]', $m);
        }

        $m = (str_replace('[To:', '[to:', $m));

        if (preg_match_all('/\[To:([0-9]+)\]/', $m, $matchs)) {
            foreach ($matchs[1] as $match) {
                if ((int) $match > 1000) {
                    if (isset($mapping_user[$match])) {
                        $m = (str_replace('[To:' . $match . ']', '[to:' . $mapping_user[$match]['id_sns'] . ']', $m));
                    }
                }
            }
        }

        return $m;
    }
}
