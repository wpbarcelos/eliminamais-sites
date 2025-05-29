<?php

use App\Http\Middleware\CheckSubdomainMiddleware;
use App\Livewire\Site\HomePage;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


require __DIR__ . '/auth.php';

Route::get('/', HomePage::class)->middleware(CheckSubdomainMiddleware::class);

Volt::route('/{page}', 'page.show')->middleware(CheckSubdomainMiddleware::class);