<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\UserServiceInterface;
use App\Data\UpdateUserData;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Spatie\LaravelData\Exceptions\CannotCreateData;

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
    public function edit(int $id): View|RedirectResponse
    {
        try {

            $user = $this->userService->findById($id);

            return view('admin.userEdit', compact('user'));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.users')->with('error', 'User not found.');
        } catch (CannotCreateData $e) {

            return redirect()->route('admin.users')->with('error', 'Invalid input.');
        }
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
        try {
            $data = UpdateUserData::from($request->validated());
            $user = $this->userService->update($id, $data);

            if ($user) {

                return redirect()->route('admin.users')->with('success', 'User updated successfully.');
            }

            return redirect()->route('admin.users')->with('error', 'Failed to update user.');

        } catch (CannotCreateData $e) {

            return redirect()->route('admin.users')->with('error', 'Invalid input.');
        }
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
