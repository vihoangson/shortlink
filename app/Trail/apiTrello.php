<?php

namespace App\Trail;




use Guzzle\Http\Message\Request;
use GuzzleHttp\Client;

trait apiTrello {

    private static function createBoard() {


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
    "idList": "6322dd0bd248cc0062a17005",
    "token": "d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0",
    "key": "2b7a2577e1d6fa13b409bd822a1b5734",
    "idCardSource":"6322e47a6284de00ec5fcc12",
    "name": "tienvao",
    "desc": "{\\"name\\":\\"Khoản thu\\",\\"value\\":\\"10000\\",\\"auth\\":1}",
    "pos": 4
}',
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
}
