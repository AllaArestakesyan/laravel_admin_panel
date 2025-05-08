<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
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
     * Summary of index
     * 
     * @return View
     */
    public function index(): View
    {
        $users = $this->userService->findAll();
        return view('admin.users', compact('users'));
    }

    /**
     * Summary of edit
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = $this->userService->findById($id);

        return view('admin.userEdit', compact('user'));
    }

    /**
     * Summary of update
     * 
     * @param UpdateUserRequest $request
     * @param mixed $id
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id): RedirectResponse
    {
        $data = $request->all();
        $user = $this->userService->update($id, $data);

        if ($user) {

            return redirect()->route('admin.users')->with('success', 'User updated successfully.');
        }

        return redirect()->route('admin.users')->with('error', 'Failed to update user.');
    }

    /**
     * Summary of destroy
     * 
     * @param mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $success = $this->userService->delete($id);

        if (!$success) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
