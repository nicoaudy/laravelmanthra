<?php

$namespace = 'NicoAudy\LaravelManthra\Http\Controllers';

Route::namespace($namespace)->prefix('manthra')->group(function () {
     Route::get('/', 'ManthraController@index');
     Route::post('/', 'ManthraController@store')->name('generate-manthra');
});
