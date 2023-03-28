<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConversationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user/tokens', function (Request $request) {
        return $request->user()->tokens;
    });
    Route::get('/billing/intent', function (Request $request) {
        $data['user'] = $request->user();
        $data['intent'] = $request->user()->createSetupIntent();
        return $data;
    });
    Route::get('/billing/url', function (Request $request) {
        // $paymentMethod['payment_method'] = "card";
        $data['user'] = $request->user();
        // $data['subscription'] = $request->user()->newSubscription('default', 'price_1Mp8tGSCOb5o4182Cqv4CZAp')->create("pm_1MpBhVSCOb5o4182ivmulAPu");
        $data['stripe_user'] = $request->user()->createOrGetStripeCustomer();
        $data['url'] = $request->user()->billingPortalUrl('http://localhost:3000/playground');
        return $data;
    });

    Route::post('/conversation', [ConversationController::class, 'save']);

    Route::post('/conversation/update', [ConversationController::class, 'update']);

    Route::post('/ai/chat', [ConversationController::class, 'chat']);

    Route::get('/conversation', [ConversationController::class, 'index']);
    Route::get('/templates', [ConversationController::class, 'templates']);

    Route::get('/conversation/{id}', [ConversationController::class, 'show']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/admin', [AdminController::class, 'admin']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);