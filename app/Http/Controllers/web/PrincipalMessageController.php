<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PrincipalDesk;
use Illuminate\View\View;

class PrincipalMessageController extends Controller
{
    public function __invoke(): View
    {
        // Only one entry is managed in admin; show it if it's active.
        $principal = PrincipalDesk::active()->first();

        return view('web.principal-message', compact('principal'));
    }
}

/*
|--------------------------------------------------------------------------
| routes/web.php
|--------------------------------------------------------------------------
| use App\Http\Controllers\Web\PrincipalMessageController;
|
| Route::get('/principal-message', PrincipalMessageController::class)
|     ->name('principal-message');
|
| Menu link:  <a href="{{ route('principal-message') }}">Principal's Message</a>
*/