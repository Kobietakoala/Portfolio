<?php

declare(strict_types=1);


namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Attribute\Route;

class HomeController extends Controller
{
    /**
     * @return Renderable
     */
    #[Route('/', methods: ['GET'], name: 'home')]
    public function index()
    {
        return view('portfolio.home');
    }
}
