<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\StudentController;
use App\Models\Student;
use Illuminate\Routing\RouteGroup;

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

Route::post("register", [StudentController::class, 'register']);
Route::post("login", [StudentController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get("profile", [StudentController::class, 'profile']);
    Route::get("logout", [StudentController::class, 'logout']);
    
    Route::post("create-project", [ProjectController::class, 'createProject']);
    Route::get("list-project", [ProjectController::class, 'listProject']);
    Route::get("single-project/{id}", [ProjectController::class, 'singleProject']);
    Route::delete("delete-project/{id}", [ProjectController::class, 'deleteProject']);
});
