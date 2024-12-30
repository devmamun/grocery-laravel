<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Handle user login
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (! $this->attemptLogin($request)) {
            return $this->error('Invalid credentials', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->success('Login successful', $this->getLoginResponse());
    }

    /**
     * Logout the authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->performLogout($request);
            return $this->success('Successfully logged out');
        } catch (\Exception $e) {
            return $this->error(
                'Logout failed',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Attempt to log the user in
     *
     * @param LoginRequest $request
     * @return bool
     */
    private function attemptLogin(LoginRequest $request): bool
    {
        return Auth::attempt($request->only(['email', 'password']));
    }

    /**
     * Get the login response data
     *
     * @return array
     */
    private function getLoginResponse(): array
    {
        $user = Auth::user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return [
            'user' => $user,
            'access_token' => $accessToken
        ];
    }

    /**
     * Perform logout actions
     *
     * @param Request $request
     * @return void
     */
    private function performLogout(Request $request): void
    {
        $request->user()->tokens()->delete();
        Auth::guard('web')->logout();
    }

    /**
     * Return success response
     *
     * @param string $message
     * @param array|null $data
     * @param int $status
     * @return JsonResponse
     */
    private function success(string $message, ?array $data = null, int $status = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'status' => 'success',
            'message' => $message,
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Return error response
     *
     * @param string $message
     * @param int $status
     * @param array|null $errors
     * @return JsonResponse
     */
    private function error(string $message, int $status, ?array $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
