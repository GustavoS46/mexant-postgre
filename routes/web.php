<?php


use App\Http\Controllers\TemplatComtroller;
use Illuminate\Support\Facades\Route;



/*Route::get('/', [HomeController::class, 'index'])->name('home');*/
route::get('/', [TemplatComtroller::class, 'index']);
