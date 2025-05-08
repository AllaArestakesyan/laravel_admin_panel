<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    /**
     * Inject the UserService into the controller.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(private UserServiceInterface $userService)
    {
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->userService->findAll();
        return response()->json($users);
    }

    /**
     * Get a user by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = $this->userService->findById($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $user = $this->userService->update($id, $data);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Summary of uploadAvatar
     * 
     * @param \App\Http\Requests\FileRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function uploadAvatar(FileRequest $request)
    {
        $data = $request->all();
        $user = $this->userService->uploadAvatar($request->user()->id, $data);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $success = $this->userService->delete($id);
        if ($success) {
            return response()->json(['message' => 'User deleted']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
