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
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('registerPost');
});

Route::middleware('notLogin')->group(function () {
    Route::middleware('isAdmin')->prefix('admin')->name("admin.")->group(function () {

        Route::get('/panel', [adminPanel::class, "index"])->name('dashboard');

        //Start Comment
        Route::post('/project/task/comment/{id}', [CommentController::class, 'store'])->name('comment');
        Route::get('/comment/{id}', [CommentController::class, 'delete'])->name('comment.delete');
        //End Comment

        //Start Project
        Route::get('/project/trash', [ProjectController::class, 'trashed'])->name('projects.trash');
        Route::resource('project', 'App\Http\Controllers\admin\ProjectController');
        Route::get('/dataTableProjects', [ProjectController::class, 'indexDataTable'])->name('project.index.dataTable');
        Route::get('/dataTableTrashed', [ProjectController::class, 'trashedDataTable'])->name('project.trashed.show.dataTable');
        Route::get('/restoreTrashed/{id}', [ProjectController::class, 'restoreProject'])->name('project.restore');
        Route::delete('/hardDelete/{id}', [ProjectController::class, 'hardDelete'])->name('project.hard.delete');
        //End Project

        //Start Add User
        Route::resource('addUser', 'App\Http\Controllers\admin\AddUserController');
        Route::get('/dataTableUsers', [AddUserController::class, 'indexDataTable'])->name('addUser.index.dataTable');
        Route::get('/dataTableUser/{id}', [AddUserController::class, 'showDataTable'])->name('addUser.show.dataTable');
        //End Add User

        //Start Task
        Route::resource('task', 'App\Http\Controllers\admin\TaskController');
        Route::post('task/status/{id}', [TaskController::class, 'taskSortable'])->name('task.sortable');
        //End Task
    });

    Route::middleware('isUser')->prefix('user')->name('user.')->group(function () {

        Route::get('/panel', [userPanel::class, "index"])->name('dashboard');

        //Start Comment
        Route::post('/project/task/comment/{id}', [CommentController::class, 'store'])->name('comment');
        Route::get('/comment/{id}', [CommentController::class, 'delete'])->name('comment.delete');
        //End Comment

        //Start Project
        Route::get('/project', [userPanel::class, "project_index"])->name('project.index');
        Route::get('/dataTableUserProjects', [userPanel::class, 'indexDataTable'])->name('project.index.dataTable');
        Route::get('/project/show/{id}', [userPanel::class, "projectShow"])->name('project.show');
        //End Project

        //Start Task
        Route::post('/task/status/{id}', [userPanel::class, 'taskSortable'])->name('task.sortable');
        Route::post('/task/create', [userPanel::class, "store"])->name('task.create');
        Route::put('/task/update/{id}', [userPanel::class, 'update'])->name('task.update');
        Route::delete('/task/destroy/{id}', [userPanel::class, "destroy"])->name('task.destroy');
        //End Task
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/{id}', [ProfileController::class, 'postProfile'])->name('profilePost');
    Route::get('/changePassword', [ProfileController::class, 'changePass'])->name('changePass');
    Route::post('/changePassword/{id}', [ProfileController::class, 'postChangePass'])->name('postChangePass');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::fallback(function () {
        return view('layouts.loginErrorPage');
    });
});
