<?php

$namespace = 'NicoAudy\LaravelManthra\Http\Controllers';

Route::namespace($namespace)->prefix('manthra')->middleware('auth')->group(function () {
     Route::get('/', 'ManthraController@index');
     Route::post('/', 'ManthraController@store')->name('generate-manthra');
});
