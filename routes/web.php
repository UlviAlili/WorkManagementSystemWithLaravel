<?php

use App\Http\Controllers\admin\AddUserController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\DashboardController as adminPanel;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\TaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\DashboardController as userPanel;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::middleware('isLogin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('registerPost');
});

Route::middleware('notLogin')->group(function () {
    Route::prefix('admin')->name("admin.")->group(function () {
        Route::get('/panel', [adminPanel::class, "index"])->name('dashboard');
        Route::resource('project', 'App\Http\Controllers\admin\ProjectController');
        Route::resource('addUser', 'App\Http\Controllers\admin\AddUserController');
        Route::resource('task', 'App\Http\Controllers\admin\TaskController');
        Route::get('/task/createTask/{id}', [TaskController::class, 'createTask'])->name('create-task');

        Route::get('/dataTableUsers', [AddUserController::class, 'indexDataTable'])->name('create-dataTable-user');
        Route::get('/dataTableUser/{id}', [AddUserController::class, 'showDataTable'])->name('show-dataTable-user');
        Route::get('/dataTableTasks', [TaskController::class, 'indexDataTable'])->name('create-dataTable-task');
        Route::get('/dataTableProjects', [ProjectController::class, 'indexDataTable'])->name('create-dataTable-project');
        Route::get('/dataTableProject/{id}', [ProjectController::class, 'showDataTable'])->name('show-dataTable-project');


        Route::get('/tasks/selectProject', [TaskController::class, 'selectProject'])->name('select-project');
        Route::post('/tasks/selectProject', [TaskController::class, 'selectProjectPost'])->name('select-project-post');
        Route::post('/comment/{id}', [CommentController::class, 'update'])->name('comment');
        Route::get('/comment/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    });
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/panel', [userPanel::class, "index"])->name('dashboard');
        Route::get('/task', [userPanel::class, "task"])->name('task.index');

        Route::get('/dataTableUserTasks', [userPanel::class, 'indexDataTable'])->name('create-user-dataTable-task');

        Route::get('/task/status/{id}', [userPanel::class, "taskStatus"])->name('task.status');
        Route::get('/task/edit/{id}', [userPanel::class, "taskEdit"])->name('task.edit');
        Route::post('/task/edit/{id}', [userPanel::class, "taskUpdate"])->name('task.update');
        Route::get('/comment/{id}', [userPanel::class, "delete"])->name('comment.delete');
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/{id}', [ProfileController::class, 'postProfile'])->name('profilePost');
    Route::get('/changePass', [ProfileController::class, 'changePass'])->name('changePass');
    Route::post('/changePass/{id}', [ProfileController::class, 'postChangePass'])->name('postChangePass');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::fallback(function () {
        return view('layouts.loginErrorPage');
    });
});
