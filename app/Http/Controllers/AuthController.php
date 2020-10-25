<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

/**
 * [Description AuthController]
 */
class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param RegisterRequest $request
     * 
     * @return [type]
     */
    public function register(RegisterRequest $request)
    {
        try {
            return $this->authService->register();
        } catch (\Throwable $t) {
            return response()->json(['error' => $t->getMessage()], 500);
        }
    }
}
