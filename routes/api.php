<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TestimonialController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('v1/contacts', ContactController::class);
Route::apiResource('v1/members', MemberController::class);
Route::get('v1/organization', [OrganizationController::class, 'index']);
Route::put('v1/organization', [OrganizationController::class, 'update']);
Route::apiResource('v1/projects', ProjectController::class);
Route::apiResource('v1/testimonials', TestimonialController::class);
