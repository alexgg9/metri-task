<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;


// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas de usuario
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::get('/users', [UserController::class, 'index']);
    // Rutas de proyectos
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    // Rutas de tareas
    Route::get('projects/{id}/tasks', [ProjectController::class, 'getProjectTasks']);
    Route::apiResource('tasks', TaskController::class);

    // Nuevas rutas para usuarios en proyectos
    Route::get('/projects/{projectId}/users', [UserController::class, 'getProjectUsers']);
    Route::post('/projects/{projectId}/users', [UserController::class, 'addUserToProject']);
    Route::delete('/projects/{projectId}/users/{userId}', [UserController::class, 'removeUserFromProject']);

    Route::get('/user-tasks', [TaskController::class, 'getUserTasks']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
});
