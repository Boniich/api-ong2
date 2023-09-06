<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SocialMediaItemController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('v1/organization', [OrganizationController::class, 'index']);
    Route::apiResource('v1/slides', SlideController::class);
    Route::apiResource('v1/categories', CategoryController::class);
    Route::apiResource('v1/activities', ActivityController::class);
    Route::apiResource('v1/news', NewsController::class);
    Route::apiResource('v1/comments', CommentController::class);
    Route::apiResource('v1/roles', RoleController::class);
});

Route::post('v1/register', [AuthController::class, 'register']);
Route::post('v1/login', [AuthController::class, 'login']);
Route::apiResource('v1/contacts', ContactController::class);
Route::apiResource('v1/members', MemberController::class);

Route::put('v1/organization', [OrganizationController::class, 'update']);
Route::apiResource('v1/projects', ProjectController::class);
Route::apiResource('v1/testimonials', TestimonialController::class);
Route::apiResource('v1/socialmediaitems', SocialMediaItemController::class);
Route::apiResource('v1/users', UserController::class);
Route::apiResource('v1/slides', SlideController::class, ['only' => 'index']);
Route::apiResource('v1/categories', CategoryController::class, ['only' => 'index']);
Route::apiResource('v1/activities', ActivityController::class, ['only' => 'index']);
Route::apiResource('v1/news', NewsController::class, ['only' => 'index']);
Route::apiResource('v1/comments', CommentController::class, ['only' => 'index']);
