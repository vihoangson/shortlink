<?php

use App\Models\Message;
use App\Services\RouteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {      
    echo Auth::user()->name;    
    $keys = \App\Models\Shortlink::all()->reverse();
    view()->share('keys', $keys);   
    return view('shortlink.index');
});
Route::get('/d/{key}', function($key) {   

    $k = \App\Models\Shortlink::where('short',$key)->first()->long;
    return redirect($k);
    return view('shortlink.index');
});

Route::post('/', function(Request $request) {
    $longurl = $request->input('longurl');
    $shorturl = substr(md5($request->input('longurl').time()),4,6);
    $sl = new \App\Models\Shortlink;
    $sl->long =$longurl;
    $sl->short =$shorturl;
    $sl->save();
    $keys = \App\Models\Shortlink::all()->reverse();
    view()->share('keys', $keys);

    view()->share('shorturl', $shorturl);
    return redirect('/');
});
Auth::routes();

//Route login google
Route::get('auth/{driver}',[\App\Http\Controllers\Socialite\SocialiteController::class,'redirectToProvider'])->name('login.provider');
Route::get('auth/{driver}/callback',[\App\Http\Controllers\Socialite\SocialiteController::class,'handleProviderCallback'])->name('login.provider.callback');