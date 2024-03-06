<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserAuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/teste', function () {
    dd('teste');
});

Route::post('/login', [AuthController::class, 'auth'])->name('login');

Route::post('/register', [UserAuthController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/', [TaskController::class, 'listTasks']);
        Route::get('/{id}', [TaskController::class, 'searchTaskById']);
        Route::post('/', [TaskController::class, 'createTask']);
        Route::put('/{id}', [TaskController::class, 'updateTask']);
        Route::patch('/complete/{id}', [TaskController::class, 'completeTask']);
        Route::delete('/{id}', [TaskController::class, 'deleteTask']);
    });
});
