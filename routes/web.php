<?php

use App\Http\Controllers\LinkController;
use App\Models\Message;
use App\Models\User;
use App\Services\RouteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Packages\QRCode;

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
Route::get('/', function () {
    if (config('app.env') == 'local') {
        Auth::login(User::find(1));
    }
    if (Auth::check()) {
        $keys = \App\Models\Shortlink::where('user_id', Auth::id())
                                     ->get()
                                     ->reverse();
    } else {
        Session::flash('alert_error', "Please login !");
        Session::flash('show_login_google', 1);
        $keys = \App\Models\Shortlink::where('is_public', 1)
                                     ->get()
                                     ->reverse();
    }

    view()->share('keys', $keys);

    return view('shortlink.index');
});

Route::resource('link', LinkController::class);

Route::post('/', function (Request $request) {
    if (!Auth::check()) {
        return redirect('/');
    }
    $longurl  = $request->input('longurl');
    $name     = $request->input('name');
    $shorturl = $request->input('shorturl', false);
    if (!$shorturl) {
        $shorturl = substr(md5($request->input('longurl') . time()), 4, 6);
    }

    $is_public = $request->input('is_public');

    $sl            = new \App\Models\Shortlink;
    $sl->long      = $longurl;
    $sl->name      = $name;
    $sl->short     = $shorturl;
    $sl->is_public = $is_public;
    $sl->user_id   = Auth::id();

    $sl->save();
    $keys = \App\Models\Shortlink::all()
                                 ->reverse();
    view()->share('keys', $keys);

    view()->share('shorturl', $shorturl);

    return redirect('/');
});
Auth::routes();
Route::get('/logout', function () {
    Auth::logout();

    return redirect('/');
});
//Route login google
Route::get('auth/{driver}', [\App\Http\Controllers\Socialite\SocialiteController::class, 'redirectToProvider'])
     ->name('login.provider');
Route::get('auth/{driver}/callback', [
    \App\Http\Controllers\Socialite\SocialiteController::class,
    'handleProviderCallback'
])
     ->name('login.provider.callback');
Route::get('/404', function ($key) {
    return '404';
});
Route::get('/qrcode', function (Request $request) {
    $text    = ($request->input('text'));
    $iqrcode = new QRCode($text);
    $image   = $iqrcode->render_image();

    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
    exit;
});
Route::get('/{key}', function ($key) {
    $data = \App\Models\Shortlink::where('short', $key)
                                 ->first();
    if ($data == null) {
        return redirect('/404');
    } else {
        $k = $data->long;

        return redirect($k);
    }
});
