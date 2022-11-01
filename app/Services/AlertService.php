<?php

namespace App\Services;

class AlertService {

    public static function notification($message) {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'http://notix.io/api/send?app='.config('app.notificationAppId'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => '{
    "message":{
        "icon":"https://ss-hn-1.bizflycloud.vn/file_ap/files/1666681276VHS__2022-10-25__14_01_00.png/1666681276VHS__2022-10-25__14_01_00.png",
        "inapp_event": "main",
        "text": "' . $message . '",
        "title": "AP - Peaceful Land ! ",
        "url": "https://ap.oop.vn/chat"

    },
    "ttl":60
}',
            CURLOPT_HTTPHEADER     => [
                'Authorization-Token: e9fb704bcd181c6de022d93cc6c2ec21273b4c469c7e4a14',
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        return $response;
    }

    public static function chatwork(string $message) {
        $message = '[toall]' . config('app.url') . " : " . $message;
        $curl    = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'https://api.chatwork.com/v2/rooms/295837714/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => 'body=' . $message,
            CURLOPT_HTTPHEADER     => [
                'X-ChatWorkToken: ' . config('app.token_chatwork', '6598c5b05c7c3a1508f35fe465474caff'),
                'Content-Type: application/x-www-form-urlencoded'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;

    }
}
