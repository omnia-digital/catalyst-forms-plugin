<?php

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

use Modules\Forms\Http\Livewire\Form;

Route::name('forms.')->prefix('forms')->group(function () {
    Route::get('/forms/{form}', Form::class)->name('form');
});
