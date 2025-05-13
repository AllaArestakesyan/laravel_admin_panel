<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminServiceInterface;
use App\Data\SignInUserData;
use App\Data\StoreAdminData;
use App\Data\UpdateAdminData;
use App\Data\UpdateUserPasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInUserRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminAuthController extends Controller
{


    /**
     * Inject the adminService into the controller.
     *
     * @param AdminServiceInterface $authService
     */
    public function __construct(private AdminServiceInterface $adminService)
    {

    }

    /**
     * Summary of showLoginForm
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Summary of login
     * 
     * @param \App\Http\Requests\SignInUserRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function login(SignInUserRequest $request): mixed
    {
        $data = SignInUserData::from($request->validated());
        $auth = $this->adminService->signIn($data);

        if ($auth) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/profile');
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    /**
     * Summary of showRegisterForm
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegisterForm(): View
    {
        return view('admin.auth.register');
    }

    /**
     * Summary of register
     * 
     * @param \App\Http\Requests\StoreAdminRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function register(StoreAdminRequest $request): mixed
    {
        $data = StoreAdminData::from($request->validated());
        $auth = $this->adminService->signUp($data);

        if ($auth) {

            return redirect()->route('admin.admins');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    /**
     * Summary of logout
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): mixed
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }

    /**
     * Summary of profile
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function profile(): View
    {
        $admin = Auth::guard('web')->user();

        return view('admin.profile', compact('admin'));
    }


    /**
     * Summary of settings
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function settings(): View
    {
        return view('admin.settings');
    }


    /**
     * Summary of index
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $admins = $this->adminService->findAll();

        return view('admin.admins', compact('admins'));
    }

    /**
     * Summary of edit
     * 
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {

            $admin = $this->adminService->findById($id);
            $roles = Role::where('name', '!=', 'super-admin')->get();

            return view('admin.adminEdit', compact('admin', "roles"));
        } catch (ModelNotFoundException $e) {

            return redirect()->route('admin.admins')->with('error', 'Failed to update admin.');

        }
    }

    /**
     * Summary of update
     * 
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAdminRequest $request, int $id): RedirectResponse
    {
        $data = UpdateAdminData::from($request->validated());
        $admin = $this->adminService->update($id, $data);

        if ($admin) {

            return redirect()->route('admin.admins')->with('success', 'Admin updated successfully.');
        }

        return redirect()->route('admin.admins')->with('error', 'Failed to update admin.');
    }

    /**
     * Summary of settings Update
     * 
     * @param \App\Http\Requests\UpdateAdminRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function settingsUpdate(UpdateAdminRequest $request): RedirectResponse
    {
        $data = UpdateAdminData::from($request->validated());
        $admin = $this->adminService->update($request->user()->id, $data);

        if ($admin) {

            return redirect()->route('admin.profile')->with('success', 'Admin updated successfully.');
        }

        return redirect()->route('admin.profile')->with('error', 'Failed to update admin.');
    }


    /**
     * Summary of settingsUpdatePassword
     * 
     * @param \App\Http\Requests\UpdateUserPasswordRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function settingsUpdatePassword(UpdateUserPasswordRequest $request): RedirectResponse
    {
        $data = UpdateUserPasswordData::from($request->validated());
        $admin = $this->adminService->updatePassword($request->user()->id, $data);

        if ($admin) {

            return redirect()->route('admin.profile')->with('success', 'Admin password updated successfully.');
        }

        return redirect()->route('admin.profile')->with('error', 'Failed to update admin.');
    }

    /**
     * Summary of destroy
     * 
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $success = $this->adminService->delete($id);

        if (!$success) {
            return redirect()->route('admin.admins')->with('error', 'Admin not found.');
        }

        return redirect()->route('admin.admins')->with('success', 'Admin deleted successfully.');
    }

    /**
     * Summary of removeRole
     * 
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function removeRole(int $id, Request $request): RedirectResponse
    {
        $role = $request->input('role');
        $data = $this->adminService->removeRole($id, $role);

        return back()->with($data->error ? 'error' : 'success', $data->message);
    }
}