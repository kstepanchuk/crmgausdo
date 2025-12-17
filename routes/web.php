<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::view('/', 'welcome');

Route::get('/help', function () {
    $markdown = Storage::disk('local')->exists('help.md')
        ? Storage::disk('local')->get('help.md')
        : '# Help file not found';

    return \Illuminate\Support\Str::markdown($markdown);
});
