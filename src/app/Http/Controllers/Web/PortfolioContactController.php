<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Attribute\Route;

#[Route(prefix: 'web/v1', name: 'web.')]
#[Middleware('web')]
class PortfolioContactController extends Controller
{
    #[Route('/contact', methods: ['POST'], name: 'contact')]
    public function __invoke()
    {
        /** @TODO add contact */
        return response()->json(['ok']);
    }
}
