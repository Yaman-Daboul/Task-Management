<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'getUser'])->middleware('auth:sanctum');
Route::get('/allusers', [UserController::class, 'getAllUsers'])->middleware('auth:sanctum');

Route::get('welcome to api', function () {
    return 'welcome to api';

});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('users', UserController::class);
Route::get('/user/{id}/profile', [UserController::class, 'getProfileUser']);
Route::get('/user/{id}/tasks', [UserController::class, 'getUserTasks']);

// Route::get('/tasks', [TaskController::class, 'index']);
// Route::get('/tasks/{id}', [TaskController::class, 'show']);
// Route::post('/tasks', [TaskController::class, 'store']);
// Route::put('/tasks/{id}', [TaskController::class, 'update']);
// Route::delete('/tasks/{id}',[TaskController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('profile', ProfileController::class);

    Route::apiResource('categories', CategoryController::class);

    Route::prefix('tasks')->group(function () {
        Route::get('/{id}/user', [TaskController::class, 'getTaskUser']);
        Route::post('/{taskId}/categories', [TaskController::class, 'addCategoriesToTask']);
        Route::get('/{tasksId}/categories', [TaskController::class, 'getTaskCategories']);
        Route::get('/all', [TaskController::class, 'getTasksAll'])->middleware('checkUser');
        Route::get('/ordered', [TaskController::class, 'getTasksOrdered']);
    });

    Route::post('tasks/{id}/favorite', [TaskController::class, 'addToFavorites']);
    Route::delete('tasks/{id}/favorite', [TaskController::class, 'removeFromFavorites']);
    Route::get('tasks/favorites', [TaskController::class, 'getFavoriteTasks']);

    Route::apiResource('tasks', TaskController::class);

    Route::get('categories/{categoryId}/tasks', [TaskController::class, 'getCategoryTasks']);
});
// Route::middleware('auth:sanctum')
//     ->put('/profile/{userId?}', [ProfileController::class, 'update']);
