<?php

namespace App\Services;
use App\Entity\Money;
use App\Trail\apiTrello;
use Guzzle\Http\Message\Request;
use GuzzleHttp\Client;

class MoneyService
{
    use apiTrello;
    public static function addMoney(Money $money){
        self::createBoardGuzzel();
    }
    public static function createBoardGuzzel(){
        TrelloService::addMoney();
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = '{
  "idList": "6322dd0bd248cc0062a17005",
  "token": "d4cced5d2dc02b7e90b88bcd3e275de666d54506185f34658a1fe201647a8ab0",
  "key": "2b7a2577e1d6fa13b409bd822a1b5734",
  "name": "tienvao",
  "desc": "{\"name\":\"Khoản thu\",\"value\":\"10000\",\"auth\":1}",
  "pos": 4
}';
        $request = new Request('POST', 'https://api.trello.com/1/cards', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        echo $res->getBody();
    }
}
