<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/sss', function () {
    // return 'working';
    $api = Http::withHeaders([
        'Authorization' => 'Bearer Y7o2sXZRIvYYXcDyWXe5wSqf541PNuz6bn8Cr90W5nYZ6S4vjCUSXBB0Mo3Y',
        'Content-Type' => 'application/json'
    ])->post('https://zapito.com.br/api/messages', [
        "test_mode" => true,
        "data" => [
            [
            "phone" => "5531987324565",
            "message" => "Olá mundo!\n *Negrito* _itálico_ e EMOJIs: 🤖",
            "bot_id" => "20462",
            "file" => [
                "url" => "https://via.placeholder.com/400",
                "name" => "arquivo_exemplo.png",
                "headers" => [
                "X-Custom-Header" => "valor_custom_header"
                ],
                "optional" => false
            ],
            "meta" => "Opcional - Não utilizado pelo Zapito",
            "check_phone" => true
            ]
        ]
    ]);

    return $api;

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
