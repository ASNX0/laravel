<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;

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

Route::get('/noti', function () {
   $SERVER_API_KEY="AAAA5hqNBc8:APA91bEL8iHWLbtWGIGu3N0ImjiM31MM7DaXm5lkY3av0SbQSFES3uoVDEtSyRJPI7jKdC7CyPm8wVnhHx6Xtjbry-CZNUhavB9aiLEIbMZ8jexUvioTIKsuaKZycSjT4LcKAgaGQwwr";
   $token_1="feSETIz4QeqZno_MWBP7tE:APA91bGbOHbPEEk4K9S5VoVmH1zI_1_eDkbWF8N6si4lypYjpBfnSW3lVDPgkokHWAkdrWn_yMgRRpBjPKzqW1VSnHSwcJPpNQGY0wM05ilUYYcKleplxaNb4jSmYu7CkacXHZVsZtbv";
   $data = [

        "registration_ids" => [
            $token_1
        ],

        "notification" => [

            "title" => 'Welcome',

            "body" => 'Description',

            "sound"=> "default" // required for sound on ios

        ],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

    dd($response);

});

// Auth::routes(['verify'=>true]);
Route::get('email/verify/{id}', [App\Http\Controllers\VerificationController::class,'verify'])->name('verification.verify');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
