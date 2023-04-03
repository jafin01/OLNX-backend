<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ConversationController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::group(['middleware' => ['auth:sanctum', 'verified', 'admin']], function() {
    Route::get('/admin', [AdminController::class, 'admin']);
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('http://localhost:3000/playgrounds');
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return ['message' => 'Email sent!'];
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/user', function (Request $request) {
        $data['user'] = $request->user();
        $data['subscribed'] = $request->user()->subscribed('default');
        return $data;
    });
    Route::get('/user/tokens', function (Request $request) {
        return $request->user()->tokens;
    });
    Route::get('/billing/intent', [BillingController::class, 'intent']);

    Route::post('/billing', [BillingController::class, 'save']);

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
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);