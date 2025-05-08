<aside class="w-64 bg-white shadow-lg h-screen p-6 space-y-6">
    <div class="text-2xl font-bold text-blue-600">Admin Panel</div>
    <nav class="flex flex-col space-y-3">
        <p>{{ $role }}</p>
        <a href="{{ route('admin.profile') }}" class="text-gray-700 hover:text-blue-600 font-medium">Profile</a>
        @if(in_array('super-admin', explode(", ", $role)))
            <a href="{{ route("admin.register") }}" class="text-gray-700 hover:text-blue-600 font-medium">Create Admin</a>
            <a href="{{ route("admin.admins") }}" class="text-gray-700 hover:text-blue-600 font-medium">Admins Or
                Managers</a>
        @endif

        <a href="{{ route('admin.skills') }}" class="text-gray-700 hover:text-blue-600 font-medium">Skills</a>
        <a href="{{ route('admin.jobs') }}" class="text-gray-700 hover:text-blue-600 font-medium">Jobs</a>

        @if(
                in_array('super-admin', explode(", ", $role))
                || in_array('admin', explode(",", $role))
            )
            <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-blue-600 font-medium">Users</a>
            <a href="{{ route('admin.skills.create') }}" class="text-gray-700 hover:text-blue-600 font-medium">Add Skill</a>
        @endif

        @if(
                in_array('super-admin', explode(", ", $role))
                || in_array('manager', explode(", ", $role))
            )
            <a href="{{ route('admin.jobs.create') }}" class="text-gray-700 hover:text-blue-600 font-medium">Add Job</a>
        @endif

        <a href="{{ route('admin.settings') }}" class="text-gray-700 hover:text-blue-600 font-medium">Settings</a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="cursor: pointer;"
                class="text-red-500 hover:underline text-left">Logout</button>
        </form>
    </nav>
</aside>