<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Auth\LoginResponse;
use App\Http\Resources\Response\ErrorResponse;
use App\Http\Resources\Response\SuccessResponse;
use App\Http\Resources\User\UserResource;
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
            return response()->json(new ErrorResponse($t->getMessage()), 500);
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    /**
     * @param LoginRequest $request
     * 
     * @return [type]
     */
    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login();
            if (!$token) {
                return response()->json(new ErrorResponse('Not Authorized'), 401);
            }
            return response()->json(new LoginResponse($token), 200);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    /**
     * @param ForgetPasswordRequest $request
     * 
     * @return [type]
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        try {
            $this->authService->forgetPassword(request('email'));
            return response()->json(new SuccessResponse('Reset Password E-mail sent successfully'), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $this->authService->resetPassword();
            return response()->json(new SuccessResponse('Reset Password Done successfully'), 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(new ErrorResponse('Not Found, check your reset code'), 404);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function getProfile()
    {
        try {
            $user = auth()->user();
            return response()->json(UserResource::make($user), 200);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = $this->authService->update();
            return response()->json(UserResource::make($user), 200);
        } catch (\Throwable $t) {
            return response()->json(new ErrorResponse($t->getMessage()), 500);
        }
    }
}
