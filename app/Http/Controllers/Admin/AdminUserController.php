<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\View\View;

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
     * @return \Illuminate\Contracts\View\View
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
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View
    {
        $user = $this->userService->findById($id);

        return view('admin.userEdit', compact('user'));
    }

    /**
     * Summary of update
     * 
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id)
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $success = $this->userService->delete($id);

        if (!$success) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
