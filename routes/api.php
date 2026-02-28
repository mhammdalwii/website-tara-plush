<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RecipeCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\BalitaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ProfileController::class, 'show']);
    Route::post('/user/update', [ProfileController::class, 'update']);
    Route::post('/change-password', [ProfileController::class, 'changePassword']);
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/{recipe:slug}', [RecipeController::class, 'show']);
    Route::get('/recipe-categories', [RecipeCategoryController::class, 'index']);
    Route::get('/recipe-categories/{recipeCategory:slug}', [RecipeCategoryController::class, 'show']);
    Route::get('/education', [EducationController::class, 'getCategories']);
    Route::get('/education/categories', [EducationController::class, 'getCategories']);
    Route::get('/education/categories/{category:slug}', [EducationController::class, 'getPostsByCategory']);
    Route::get('/education/posts/{educationPost:slug}', [EducationController::class, 'showPost']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/history', [AppointmentController::class, 'history']);
    Route::get('/consultations', [ConsultationController::class, 'index']);
    Route::post('/consultations', [ConsultationController::class, 'store']);
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show']);
    Route::post('/consultations/{consultation}/reply', [ConsultationController::class, 'reply']);
    Route::delete('/consultations/{consultation}', [ConsultationController::class, 'destroy']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);
    Route::get('/balitas', [BalitaController::class, 'index']);
    Route::get('/balitas/{balita}/measurements', [BalitaController::class, 'measurements']);
});
