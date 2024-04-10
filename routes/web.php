<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReefController;
use App\Http\Controllers\MonitoringSessionController;
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
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Resource Route for Reefs, automatically creates all CRUD routes.
Route::resource('reefs', ReefController::class);
Route::resource('reefs.session', MonitoringSessionController::class)->shallow()->except(['create']);
Route::get('/reefs/{id}/monitor', [MonitoringSessionController::class, 'create'])->name('monitor');

Route::middleware('auth')->group(function () {
    //Profile routes created during scaffolding
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
