<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserServiceInterface;
use App\Data\UpdateUserData;
use App\Data\UpdateUserPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Exceptions\CannotCreateData;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $users = $this->userService->findAll();

            return response()->json($users);
        } catch (CannotCreateData $e) {

            return response()->json([
                "error" => true,
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Get a user by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {

            $user = $this->userService->findById($id);

            return response()->json($user);
        } catch (ModelNotFoundException $e) {

            return response()->json([
                'error' => true,
                'message' => 'User not found',
            ]);
        }
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        try {

            $data = UpdateUserData::from($request->validated());
            $user = $this->userService->update($request->user()->id, $data);
            if ($user) {
                return response()->json($user);
            }

            return response()->json(['message' => 'User not found']);
        } catch (ModelNotFoundException $e) {

            return response()->json(['message' => 'User not found']);
        }
    }

    /**
     * Summary of uploadAvatar
     * 
     * @param FileRequest $request
     * @return JsonResponse
     */
    public function uploadAvatar(FileRequest $request): JsonResponse
    {
        $file = $request->file('avatar');
        $user = $this->userService->uploadAvatar($request->user()->id, $file);

        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found']);
    }


    /**
     * Summary of settingsUpdatePassword

     * @param UpdateUserPasswordRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UpdateUserPasswordRequest $request): JsonResponse
    {
        $data = UpdateUserPasswordData::from($request->validated());
        $user = $this->userService->updatePassword($request->user()->id, $data);

        if ($user) {

            return response()->json($user);
        }

        return response()->json(['message' => 'User not found']);
    }


    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $success = $this->userService->delete($id);
        
        if ($success) {

            return response()->json(['message' => 'User deleted']);
        }

        return response()->json(['message' => 'User not found']);
    }
}
