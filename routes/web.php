<?php

use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/new', [CourseController::class, 'create']);
Route::post('/courses/new', [CourseController::class, 'store']);
Route::get('/courses/{title}', [CourseController::class, 'show']);
Route::get('/courses/{title}/edit', [CourseController::class, 'edit']);
Route::patch('/courses/{title}/update', [CourseController::class, 'update']);


Route::get('/courses/{title}/new-chapter', [ChapterController::class, 'create']);
Route::post('/courses/{title}/new-chapter', [ChapterController::class, 'store']);
Route::get('/courses/{title_course}/{title_chapter}', [ChapterController::class, 'show']);

Route::post('/courses/{title}/new-comment', [CommentController::class, 'store']);

require __DIR__.'/auth.php';
