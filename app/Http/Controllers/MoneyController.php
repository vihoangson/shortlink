<?php

namespace App\Http\Controllers;

use App\Http\Responses\PrettyJsonResponse;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

// curl --silent --request DELETE 'http://127.0.0.1:8000/api/money/3' \
// --header 'Content-Type: application/json' \
// curl --silent --request GET 'http://127.0.0.1:8000/api/money'
// curl --silent --request PUT 'http://127.0.0.1:8000/api/money/2' \
// --header 'Content-Type: application/json' \
// --data-raw '{
//     "value": 4442323,
// }'
// curl --silent --request POST 'http://127.0.0.1:8000/api/money' \
// --header 'Content-Type: application/json' \
// --data-raw '{
//     "value": 10,
//     "type": "minus"
// }'
class MoneyController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return new PrettyJsonResponse(Transaction::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $value              = $request->input('value');
        $type               = $request->input('type');
        $desc               = $request->input('desc');
        app()->user_id_from = 1;
        app()->user_id_to   = 2;
        $t                  = TransactionService::changeMoney($value, $type, $desc);

        return $t;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $t        = Transaction::find($id);
        $t->value = $request->input('value');
        $t->save();

        return ($t);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        /** @var Transaction $t */
        $t = Transaction::find($id);
        if ($t) {
            return $t->deleteOrFail();
        }

        return new PrettyJsonResponse(false);
        // return new PrettyJsonResponse(
        //     [
        //         'name' => 'John',
        //         'age' => 25,
        //     ]
        // );
    }
}
