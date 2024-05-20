<?php

use App\Livewire\Form;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */
Route::get('form', Form::class);
