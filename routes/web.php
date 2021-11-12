<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/callback', [FundController::class, 'callback'])->name('callback');

Route::get('/fund', [FundController::class, 'index'])->name('fund');
Route::post('/fund', [FundController::class, 'store'])->name('fund');

Route::get('/create', [PollController::class, 'index'])->name('poll.create');

Route::get('/poll/{id}', [PollController::class, 'single'])->name('single');

Route::get('/users/{user:username}/profile', [UserController::class, 'index'])->name('users');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

Route::post('/update', [ProfileController::class, 'store'])->name('update');


require __DIR__ . '/auth.php';
