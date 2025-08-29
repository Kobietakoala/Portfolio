<?php

declare(strict_types=1);


namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Service\ProfileService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Attribute\Route;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService
    ) { }

    /**
     * @return Renderable
     */
    #[Route('/', methods: ['GET'], name: 'home')]
    public function index()
    {
        $profileData = $this->profileService->getCachedProfileData();
        return view('portfolio.home', compact('profileData'));
    }
}
