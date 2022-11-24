<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontpageController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\MessagesController;

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

Route::get('/', [FrontpageController::class, 'index']);

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('episodes', EpisodesController::class)->middleware('auth');
Route::resource('messages', MessagesController::class)->middleware('auth');
Route::controller(MessagesController::class)->middleware('auth')->group(function () {
    Route::get('/messages/activate/{id}', 'activate')->name("messages.activate");
    Route::get('/messages/deactivate/{id}', 'deactivate')->name("messages.deactivate");
});

Route::get('/register', function() {
    return redirect('/login');
});

Route::post('/register', function() {
    return redirect('/login');
});