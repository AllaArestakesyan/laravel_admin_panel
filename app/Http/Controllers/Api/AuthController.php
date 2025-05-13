<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AuthServiceInterface;
use App\Data\SignInUserData;
use App\Data\StoreUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\LaravelData\Exceptions\CannotCreateData;

class AuthController extends Controller
{
    /**
     * Inject the authService into the controller.
     *
     * @param AuthServiceInterface $authService
     */
    public function __construct(private AuthServiceInterface $authService)
    {
    }


    /**
     * Summary of signUp
     * 
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return JsonResponse
     */
    public function signUp(StoreUserRequest $request): JsonResponse
    {
        try {

            $data = StoreUserData::from($request->validated());
            $auth = $this->authService->signUp($data);

            return response()->json($auth, 201);
        } catch (CannotCreateData $e) {
            return response()->json([
                'message' => 'Invalid input',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Summary of signIn
     * 
     * @param SignInUserRequest $request
     * @return JsonResponse
     */
    public function signIn(SignInUserRequest $request): JsonResponse
    {
        try {

            $data = SignInUserData::from($request->validated());
            $auth = $this->authService->signIn($data);

            if ($auth) {

                return response()->json($auth);
            } else {

                return response()->json([
                    'message' => 'Invalid credentials.'
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
        } catch (CannotCreateData $e) {

            return response()->json([
                'message' => 'Invalid input',
                'error' => $e->getMessage(),
            ]);
        }

    }

    /**
     * Summary of signOut
     * 
     * @param Request $request
     * @return JsonResponse|mixed
     */
    public function signOut(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    /**
     * Summary of profile
     * 
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse|mixed
     */
    public function profile(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
