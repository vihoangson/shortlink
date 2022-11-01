<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $fs = Feed::all();
        // foreach ($fs as $f){
        //     $f->delete();
        // }
        return Feed::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $f = new Feed;
        $f->id = $request->input('id');
        $f->content = $request->input('content');
        $f->img_cover = $request->input('upload_id');
        $f->save();
        return $f;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $f = Feed::find($id);
        $f->content = $request->input('content');
        $f->img_cover = $request->input('upload_id');
        $f->save();
        return $f;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feed $feed)
    {
        $feed->delete();
        return response()->json(null, 204);
    }
}
