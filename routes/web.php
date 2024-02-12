<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashController;
use App\Http\Controllers\NewDashboardController;
use App\Http\Controllers\PdfController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/pdf-converter', function () {
    return view('PDF_converter');
});
Route::post('/convert-pdf', [PdfController::class,'convert'])->name('convert.pdf');

Route::get('/',[DashController::class,'dashboard_show'])->name('/');
Route::post('store-audio-file',[DashController::class,'store_audio_file'])->name('store.audio');
Route::get('show-audio-file',[DashController::class,'show_audio_file'])->name('show.audio');

Route::post('store-chat-completions',[DashController::class,'chat_completions'])->name('store.completions');