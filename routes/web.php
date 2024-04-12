<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EntradasController;
use App\Http\Controllers\RamaisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// LOGIN
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');
Route::get('/create-user-login', [LoginController::class, 'create'])->name('login.create-user');
Route::post('/store-user-login', [LoginController::class, 'store'])->name('login.store-user');

// RECUPERAR SENHA
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('forgot-password.show');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submitForgotPassword'])->name('forgot-password.submit');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPassword'])->name('reset-password.show');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPassword'])->name('reset-password.submit');

Route::post('/', [LoginController::class, 'index'])->name('password.reset');

Route::group(['middleware' => 'auth'], function () {

    // LOGOUT
    Route::get('/logout', [LoginController::class, 'destroy'])->name('login.destroy');

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // PERFIL
    Route::get('/show-profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/edit-profile-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::put('/update-profile-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // USUÁRIOS
    Route::get('/index-user', [UserController::class, 'index'])->name('user.index');
    Route::get('/show-user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
    Route::post('/store-user', [UserController::class, 'store'])->name('user.store');
    Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update-user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('/edit-user-password/{user}', [UserController::class, 'editPassword'])->name('user.edit-password');
    Route::put('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('user.update-password');
    Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/generate-pdf-user', [UserController::class, 'generatePdf'])->name('user.generate-pdf');

    // CURSOS
    Route::get('/index-course', [CourseController::class, 'index'])->name('course.index');
    Route::get('/show-course/{course}', [CourseController::class, 'show'])->name('course.show');
    Route::get('/create-course', [CourseController::class, 'create'])->name('course.create');
    Route::post('/store-course', [CourseController::class, 'store'])->name('course.store');
    Route::get('/edit-course/{course}', [CourseController::class, 'edit'])->name('course.edit');
    Route::put('/update-course/{course}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/destroy-course/{course}', [CourseController::class, 'destroy'])->name('course.destroy');

    //Entradas
    Route::get('/index-entradas', [EntradasController::class, 'index'])->name('entradas.index');
    Route::post('/upload-entradas', [EntradasController::class, 'upload'])->name('entradas.upload');

    //Ramais
    Route::get('/index-ramais', [RamaisController::class, 'index'])->name('ramais.index');
    Route::post('/upload-ramais', [RamaisController::class, 'upload'])->name('ramais.upload');
    Route::post('/create-ramais', [RamaisController::class, 'create'])->name('ramais.create');
    Route::post('/update-ramais', [RamaisController::class, 'update'])->name('ramais.update');
    Route::post('/delete-ramais', [RamaisController::class, 'delete'])->name('ramais.delete');

    // Aulas
    Route::get('/index-classe/{course}', [ClasseController::class, 'index'])->name('classe.index');
    Route::get('/show-classe/{classe}', [ClasseController::class, 'show'])->name('classe.show');
    Route::get('/create-classe/{course}', [ClasseController::class, 'create'])->name('classe.create');
    Route::post('/store-classe', [ClasseController::class, 'store'])->name('classe.store');
    Route::get('/edit-classe/{classe}', [ClasseController::class, 'edit'])->name('classe.edit');
    Route::put('/update-classe/{classe}', [ClasseController::class, 'update'])->name('classe.update');
    Route::delete('/destroy-classe/{classe}', [ClasseController::class, 'destroy'])->name('classe.destroy');

    // Papéis
    Route::get('/index-role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/create-role', [RoleController::class, 'create'])->name('role.create');
    Route::post('/store-role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/edit-role/{role}', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/update-role/{role}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/destroy-role/{role}', [RoleController::class, 'destroy'])->name('role.destroy');
    
    // Permissão do papel
    Route::get('/index-role-permission/{role}', [RolePermissionController::class, 'index'])->name('role-permission.index');
    Route::get('/update-role-permission/{role}/{permission}', [RolePermissionController::class, 'update'])->name('role-permission.update');

    // Permissões ou páginas
    Route::get('/index-permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/show-permission/{permission}', [PermissionController::class, 'show'])->name('permission.show');
    Route::get('/create-permission', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/store-permission', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/edit-permission/{permission}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/update-permission/{permission}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/destroy-permission/{permission}', [PermissionController::class, 'destroy'])->name('permission.destroy');

});