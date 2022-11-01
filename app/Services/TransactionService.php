<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class TransactionService {


    public static function addMoney(int $amount,$desc) {
        $transaction = new Transaction(['value'=>$amount,'desc'=>$desc]);
        AlertService::chatwork($transaction->toJson());
        return $transaction;
    }

    public static function minusMoney(int $amount,$desc) {
        $transaction = new Transaction(['value'=>(0-$amount),'desc'=>$desc]);
        return $transaction;
    }

    public static function changeMoney($value, $type,$desc='') {

        switch ($type) {
            case 'minus':
                $t = self::minusMoney($value,$desc);
                $t->save();
            break;
            case 'add':
                $t = self::addMoney($value,$desc);
                $t->save();
            break;
        }
        return $t;
    }

}
