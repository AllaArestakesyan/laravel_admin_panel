<?php

namespace App\Http\Controllers\Api;

use App\Contracts\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function signUp(StoreUserRequest $request):JsonResponse
    {
        $data = $request->all();
        $auth = $this->authService->signUp($data);
        return response()->json($auth, 201);
    }
   
    /**
     * Summary of signIn
     * 
     * @param \App\Http\Requests\SignInUserRequest $request
     * @return JsonResponse
     */
    public function signIn(SignInUserRequest $request):JsonResponse
    {
        $data = $request->all();
        $auth = $this->authService->signIn($data);
        return response()->json($auth);
    }
    
    /**
     * Summary of signOut
     * 
     * @param Request $request
     * @return JsonResponse|mixed
     */
    public function signOut(Request $request):JsonResponse
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
    public function profile(Request $request):JsonResponse
    {
        return response()->json($request->user());
    }
}
