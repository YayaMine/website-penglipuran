<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MidtransWebhookController;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\MidtransCallbackController;
use App\Mail\TicketPaidMail;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/debug', function () {
    return response()->json(['status' => 'API OK']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{orderCode}/confirm-paid', [OrderController::class, 'confirmPaid']);
});


// Mail::to($order->email)->send(new TicketPaidMail($order));
// ✅ MIDTRANS WEBHOOK
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);
// Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);

Route::get('/packages', [PackageApiController::class, 'index']);
Route::get('/packages/{id}', [PackageApiController::class, 'show']);