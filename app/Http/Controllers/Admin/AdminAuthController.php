<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInUserRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function showLoginForm():View
    {
        return view('admin.auth.login');
    }

    /**
     * Summary of login
     * 
     * @param \App\Http\Requests\SignInUserRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function login(SignInUserRequest $request):mixed
    {
        $data = $request->only('email', 'password');
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
    public function showRegisterForm():View
    {
        return view('admin.auth.register');
    }

    /**
     * Summary of register
     * 
     * @param \App\Http\Requests\StoreAdminRequest $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function register(StoreAdminRequest $request):mixed
    {
        $data = $request->all();
        $auth = $this->adminService->signUp($data);

        if ($auth) {

            return redirect()->route('admin.users');
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
    public function logout(Request $request):mixed
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
    public function profile():View
    {
        $admin = Auth::guard('web')->user();
        return view('admin.profile', compact('admin'));
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
    public function edit(int $id): View
    {
        $admin = $this->adminService->findById($id);

        return view('admin.adminEdit', compact('admin'));
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
        $admin = $this->adminService->update($id, $data);

        if ($admin) {

            return redirect()->route('admin.admins')->with('success', 'Admin updated successfully.');
        }

        return redirect()->route('admin.admins')->with('error', 'Failed to update admin.');
    }

    /**
     * Summary of destroy
     * 
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $success = $this->adminService->delete($id);

        if (!$success) {
            return redirect()->route('admin.admins')->with('error', 'Admin not found.');
        }

        return redirect()->route('admin.admins')->with('success', 'Admin deleted successfully.');
    }
}
