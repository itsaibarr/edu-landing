<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing.home')->name('home');
Route::view('/institutions', 'landing.institutions')->name('institutions');
Route::view('/students', 'landing.students')->name('students');
