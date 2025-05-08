<aside class="w-64 bg-white shadow-lg h-screen p-6 space-y-6">
    <div class="text-2xl font-bold text-blue-600">Admin Panel</div>
    <nav class="flex flex-col space-y-3">
        <a href="{{ route('admin.profile') }}" class="text-gray-700 hover:text-blue-600 font-medium">Profile</a>
        @if($role === 'super-admin')
            <a href="{{ route("admin.register") }}" class="text-gray-700 hover:text-blue-600 font-medium">Create Admin</a>
            <a href="{{ route("admin.admins") }}" class="text-gray-700 hover:text-blue-600 font-medium">Admins Or Managers</a>
        @endif
       
        @if($role === 'super-admin' || $role === 'admin')
            <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-blue-600 font-medium">Users</a>
        @endif
        <a href="#" class="text-gray-700 hover:text-blue-600 font-medium">Settings</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="cursor: pointer;"
                class="text-red-500 hover:underline text-left">Logout</button>
        </form>
    </nav>
</aside>