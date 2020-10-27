<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\LoginResponse;
use App\Http\Resources\Response\NotAuthorizedResponse;
use App\Http\Resources\Response\ServerErrorResponse;
use App\Http\Resources\Response\SuccessResponse;
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
            return response()->json(new ServerErrorResponse($t->getMessage()), 500);
        }
    }

    /**
     * @param mixed $code
     * 
     * @return [type]
     */
    public function activate($code)
    {
        try {
            $this->authService->activate($code);
            return response()->json(new SuccessResponse('Activated Successed'), 200);
        } catch (\Throwable $t) {
            return response()->json(new ServerErrorResponse($t->getMessage()), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login();
            if (!$token) {
                return response()->json(new NotAuthorizedResponse($request), 401);
            }
            return response()->json(new LoginResponse($token), 200);
        } catch (\Throwable $t) {
            return response()->json(new ServerErrorResponse($t->getMessage()), 500);
        }
    }
}
