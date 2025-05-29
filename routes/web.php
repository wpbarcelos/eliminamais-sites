<?php

use App\Http\Middleware\CheckSubdomainMiddleware;
use App\Http\Middleware\CodigoAcessoMiddleware;
use App\Livewire\AcessoPage;
use App\Livewire\Site\HomePage;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


require __DIR__ . '/auth.php';


Route::get('acesso', AcessoPage::class)->name('acesso');

Route::middleware([CheckSubdomainMiddleware::class, CodigoAcessoMiddleware::class])->group(function () {

  Route::get('/', HomePage::class);

  Volt::route('/{page}', 'page.show');
});
