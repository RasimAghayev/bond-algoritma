<?php

use App\Http\Resources\PurchaseOrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BondController;
use App\Http\Controllers\API\PurchaseOrderController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('bonds', BondController::class);
Route::apiResource('purchaseprders', PurchaseOrderController::class);

Route::get('bond/{id}/payouts', [BondController::class,'payouts']);
Route::post('bond/{id}/order', [PurchaseOrderController::class,'store']);
