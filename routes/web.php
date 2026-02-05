<?php

use App\Filament\Pages\UploadVideo;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('/app');
});

// Route::get('/video-bab/{id}/upload', UploadVideo::class)
//     ->name('filament.admin.pages.video-bab.upload');
