<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;

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
    public function index():JsonResponse
    {
        $users = $this->userService->findAll();
        return response()->json($users);
    }

    /**
     * Get a user by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id):JsonResponse
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
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request):JsonResponse
    {
        $data = $request->all();
        $user = $this->userService->update($request->user()->id, $data);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Summary of uploadAvatar
     * 
     * @param FileRequest $request
     * @return JsonResponse
     */
    public function uploadAvatar(FileRequest $request):JsonResponse
    {
        $file = $request->file('avatar');
        $user = $this->userService->uploadAvatar($request->user()->id, $file);
      
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }


     /**
      * Summary of settingsUpdatePassword

      * @param UpdateUserPasswordRequest $request
      * @return JsonResponse
      */
     public function updatePassword(UpdateUserPasswordRequest $request):JsonResponse
    {
        $data = $request->all();
        $user = $this->userService->updatePassword($request->user()->id, $data);

        if ($user) {

            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }


    /**
     * Delete a user by its ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id):JsonResponse
    {
        $success = $this->userService->delete($id);
        if ($success) {
            return response()->json(['message' => 'User deleted']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
