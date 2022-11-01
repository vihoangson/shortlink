<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class TrelloService {

    const ID_LIST_INCOME   = '6322dd0bd248cc0062a17005';
    const ID_LIST_OUTGOING = '6322dd0feab7d602516d0a40';
    const ID_LIST_COIN     = '632d31a2f2ee9c0016a3f7f8';

    public static function getImg($d) {
        return '';
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.trello.com/1/card/' . $d->id . '/attachments/' . $d->idAttachmentCover . '?key=2b7a2577e1d6fa13b409bd822a1b5734&token=d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Cookie: dsc=cbebda1413a907c3cd77f4ba9bccdead61aa922d747bcbaa83dfeb33a4bb2dce; preAuthProps=s%3A53cfc606f5d4546f2291ddbf%3AisEnterpriseAdmin%3Dfalse.GVXeerXpZgAcJIOMWz7WAj%2BJwLqK%2BWiNZIHn6nt5IN4'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);

        return $data->url;
    }

    public static function getDataList($listID) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.trello.com//1/lists/' . $listID . '/cards?key=2b7a2577e1d6fa13b409bd822a1b5734&token=d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
                'Cookie: dsc=cbebda1413a907c3cd77f4ba9bccdead61aa922d747bcbaa83dfeb33a4bb2dce; preAuthProps=s%3A53cfc606f5d4546f2291ddbf%3AisEnterpriseAdmin%3Dfalse.GVXeerXpZgAcJIOMWz7WAj%2BJwLqK%2BWiNZIHn6nt5IN4'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);

        return $data;
    }

    public static function getCoin() {

        $listID = self::ID_LIST_COIN;
        $data   = self::getDataList($listID);
        $total  = 0;
        foreach ($data as $d) {

            if ($d->idAttachmentCover) {
                $img    = self::getImg($d);
                $d->img = $img;
            } else {
                $d->img = 'https://via.placeholder.com/150';
            }
            $data_money[] = $d;
            $d->value     = @json_decode($d->desc)->value;
            $regex        = "/\B(?=(\d{3})+(?!\d))/i";
            $valueshow    = preg_replace($regex, ",", $d->value) . " FCoin";
            $d->valueshow = $valueshow;
            $d->type      = 1;
            $d->timestamp = hexdec(substr($d->id, 0, 8)) + 25200;
            $total        += @json_decode($d->desc)->value;
        }
        $thu = $total;

        return $data_money;
    }

    public static function getTotalMoney() {

        $data_money = [];

        $listID = self::ID_LIST_INCOME;
        $data   = self::getDataList($listID);
        $total  = 0;
        foreach ($data as $d) {

            if ($d->idAttachmentCover) {
                $img    = self::getImg($d);
                $d->img = $img;
            } else {
                $d->img = 'https://via.placeholder.com/150';
            }
            $data_money[] = $d;
            $d->value     = @json_decode($d->desc)->value;
            $regex        = "/\B(?=(\d{3})+(?!\d))/i";
            $valueshow    = preg_replace($regex, ",", $d->value) . " VNĐ";
            $d->valueshow = $valueshow;
            $d->type      = 1;
            $d->timestamp = hexdec(substr($d->id, 0, 8)) + 25200;
            $total        += @json_decode($d->desc)->value;
        }
        $thu = $total;

        $listID = self::ID_LIST_OUTGOING;
        $data   = self::getDataList($listID);
        $total  = 0;
        foreach ($data as $d) {
            if ($d->idAttachmentCover) {
                $img    = self::getImg($d);
                $d->img = $img;
            } else {
                $d->img = 'https://via.placeholder.com/150';
            }
            $data_money[] = $d;
            $d->value     = @json_decode($d->desc)->value;
            $regex        = "/\B(?=(\d{3})+(?!\d))/i";
            $valueshow    = preg_replace($regex, ",", $d->value) . " VNĐ";
            $d->valueshow = $valueshow;
            $d->type      = 2;
            $d->timestamp = hexdec(substr($d->id, 0, 8)) + 25200;

            $total += @json_decode($d->desc)->value;
        }
        $chi   = $total;
        $total = $thu - $chi;
        usort($data_money, function ($a, $b) {
            return $a->timestamp < $b->timestamp;
        });

        return ['total' => $total, 'data_money' => $data_money];
    }

    public static function getTotalCoin() {

        $data_money = [];

        $listID = self::ID_LIST_COIN;
        $data   = self::getDataList($listID);
        $total  = 0;
        foreach ($data as $d) {

            if ($d->idAttachmentCover) {
                $img    = self::getImg($d);
                $d->img = $img;
            } else {
                $d->img = 'https://via.placeholder.com/150';
            }
            $data_money[] = $d;
            $d->value     = @json_decode($d->desc)->value;
            $regex        = "/\B(?=(\d{3})+(?!\d))/i";
            $valueshow    = preg_replace($regex, ",", $d->value) . " VNĐ";
            $d->valueshow = $valueshow;
            $d->type      = 1;
            $d->timestamp = hexdec(substr($d->id, 0, 8)) + 25200;
            $total        += @json_decode($d->desc)->value;
        }

        return ['total' => $total];
    }

    public static function addMoney(int $amount) {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.trello.com/1/cards',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => '{
    "idList": "'.self::ID_LIST_INCOME.'",
    "token": "d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0",
    "key": "2b7a2577e1d6fa13b409bd822a1b5734",
    "name": "tienvao",
    "desc": "{\\"name\\":\\"Khoản thu\\",\\"value\\":\\"' . $amount . '\\",\\"auth\\":1}",
    "pos": 0
}',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        self::refreshData();;

        return $response;
    }

    public static function minusMoney(int $amount) {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.trello.com/1/cards',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => '{
    "idList": "'.self::ID_LIST_OUTGOING.'",
    "token": "d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0",
    "key": "2b7a2577e1d6fa13b409bd822a1b5734",
    "name": "tienvao",
    "desc": "{\\"name\\":\\"Khoản thu\\",\\"value\\":\\"' . $amount . '\\",\\"auth\\":1}",
    "pos": 0
}',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        self::refreshData();

        return $response;
    }

    public static function addCoin(float $amount) {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.trello.com/1/cards',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => '{
    "idList": "'. self::ID_LIST_COIN.'",
    "token": "d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0",
    "key": "2b7a2577e1d6fa13b409bd822a1b5734",
    "name": "Coin",
    "desc": "{\\"name\\":\\"Khoản thu\\",\\"value\\":\\"' . $amount . '\\",\\"auth\\":1}",
    "pos": 0
}',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public static function refreshData() {
        Cache::forget('total');
        Cache::remember('total', 1000000, function () {
            $return = \App\Services\TrelloService::getTotalMoney();

            return $return;
        });
        Cache::forget('fcoin');
        Cache::remember('fcoin', 1000000, function () {
            $return = \App\Services\TrelloService::getCoin();
            return $return;
        });
    }
}
