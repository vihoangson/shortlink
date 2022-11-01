<?php

namespace App\Http\Controllers;

use App\Events\DeleteMessage;
use App\Events\SentMessage;
use App\Events\StatusLiked;
use App\Models\Message;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class MessageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $message = $request->input('message', '[]');
        $userid  = (int) $request->input('userid', 1);
        $m       = new Message(['message' => $message, 'userid' => $userid]);
        $m->save();
        event(new SentMessage($m));
        AlertService::chatwork($m->message);
        AlertService::notification('Has new message!');
        return $message;
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $ms = Message::find($id);
        event(new DeleteMessage($ms));
        $ms->delete();

        return true;
    }

}
