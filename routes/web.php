<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use App\Events\PointsReward;

use App\Http\Controllers\ApiTwitchController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use romanzipp\Twitch\Enums\GrantType;
use romanzipp\Twitch\Twitch;


use GhostZero\Tmi\Client;
use GhostZero\Tmi\ClientOptions;
use GhostZero\Tmi\Events\Irc\MessageEvent;




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
    return view('auth.login');
})->name('login');

Route::get('/example', function () {
    return view('welcome');
});

Route::get('/delet', function () {
    return view('index');
});

Route::get('/master', function () {

    event(new PointsReward());
    return 'fired';
    // $array = array (
    //     'subscription' =>
    //     array (
    //       'id' => 'f3bf522a-b370-4cec-b907-87408b39f023',
    //       'status' => 'enabled',
    //       'type' => 'channel.follow',
    //       'version' => '1',
    //       'condition' =>
    //       array (
    //         'broadcaster_user_id' => '41726771',
    //       ),
    //       'transport' =>
    //       array (
    //         'method' => 'webhook',
    //         'callback' => 'https://twitchapi.clustermx.com/api/twitch/eventsub/webhook',
    //       ),
    //       'created_at' => '2021-12-27T04:34:51.378035566Z',
    //       'cost' => 0,
    //     ),
    //     'event' =>
    //     array (
    //       'user_id' => '753201185',
    //       'user_login' => 'chenchizkanbot',
    //       'user_name' => 'chenchizkanbot',
    //       'broadcaster_user_id' => '41726771',
    //       'broadcaster_user_login' => 'chenchizkan',
    //       'broadcaster_user_name' => 'chenchizkan',
    //       'followed_at' => '2022-01-09T02:02:13.761577223Z',
    //     ),
    // );

    // return $array["subscription"];
});



////////////////  LOGIN


Route::get('/auth/twitch/redirect', function () {
    return Socialite::driver('twitch')
    ->scopes(["user:read:email", "user:edit:follows", "channel:read:subscriptions", "channel:read:redemptions", "bits:read"])
    ->redirect();
})->name('loginTwitch');

Route::get('/auth/twitch/callback', [ApiTwitchController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [ApiTwitchController::class, 'dashboard'])->name('dashboard');

    //Rutas prueba
    Route::get('/evento', [ApiTwitchController::class, 'eventoPrueba']);
    Route::get('/evento-check', [ApiTwitchController::class, 'check']);


});


//////PRUEBAS


Route::get('/twitch/test', [ApiTwitchController::class, 'EventoHost']);

Route::get('/twitch/check', [ApiTwitchController::class, 'check']);

Route::get('/twitch/delete', [ApiTwitchController::class, 'delete'])->name('delete.event');


Route::get('pruebalog', function () {
    // Log::error("Info");

});





Route::get('/lista', function () {
    $twitch = new Twitch;
    //$user = Socialite::driver('twitch')->user();

    $resultado = $twitch->getOAuthToken(null, GrantType::CLIENT_CREDENTIALS, ['channel:read:subscriptions', 'user:read:email', 'channel:manage:redemptions', 'channel:read:redemptions']);

    $access_token = $resultado->data()->access_token;

    $result = $twitch->withToken($access_token)->getEventSubs(['status' => 'enabled']);
    $second_result = $twitch->withToken($access_token)->getEventSubs(['status' => 'enabled'], $result->next());

    foreach ($second_result->data() as $item) {
        // process the subscription
        echo $item->type."<br>";
    }
});


//twitch event verify-subscription subscribe -F http://apitwitch.test/api/twitch/eventsub/webhook -s chenchosecret
//twitch event trigger subscribe -F http://apitwitch.test/api/twitch/eventsub/webhook -s chenchosecret







///////////////



Route::get('/success', [ApiTwitchController::class, 'tokenGenerator'])->name('success');


Route::get('/opciones', function (Request $request) {
    return $request->all();
})->name('opciones');

Route::post('/estrellas', [ApiTwitchController::class, 'subsInfo'])->name('estrellas');

//Se obtiene el codigo generado
Route::get('/board', function (Request $request) {

    $datos_subs = $request->get('datos_subs');

    return $datos_subs[0]->user_name;

})->name('board');



Route::get('/bot', function (){
    return view('bot');
});

