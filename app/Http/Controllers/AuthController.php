<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            return $this->authService->register();
        } catch (\Throwable $t) {
            return response()->json(['error' => $t->getMessage()], 500);
        }
    }
}
