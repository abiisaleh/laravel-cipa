<?php

use App\Http\Middleware\Authenticate;
use App\Livewire\PembayaranCreate;
use App\Livewire\PesananCreate;
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

Route::view('/', 'index')->name('home');
Route::get('/pesan', PesananCreate::class)->middleware(Authenticate::class)->name('pesan');
Route::get('/bayar', PembayaranCreate::class)->middleware(Authenticate::class)->name('bayar');
