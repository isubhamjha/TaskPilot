<?php

use App\TaskStatus;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return TaskStatus::cases();
});
