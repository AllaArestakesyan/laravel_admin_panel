<aside class="w-64 bg-white shadow-lg h-screen p-6 space-y-6">
    <div class="text-2xl font-bold text-blue-600">{{__("menu.admin_panel")}}</div>
    <nav class="flex flex-col space-y-3">
        <a href="{{ route('admin.profile') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.profile")}}</a>
        @if(in_array('super-admin', explode(", ", $role)))
            <a href="{{ route("admin.register") }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.create_admin")}}</a>
            <a href="{{ route("admin.admins") }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.admins_or_managers")}}</a>
        @endif

        <a href="{{ route('admin.skills') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.skills")}}</a>
        <a href="{{ route('admin.jobs') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.jobs")}}</a>

        @if(
                in_array('super-admin', explode(", ", $role))
                || in_array('admin', explode(",", $role))
            )
            <a href="{{ route('admin.users') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.users")}}</a>
            <a href="{{ route('admin.skills.create') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.add_skill")}}</a>
        @endif

        @if(
                in_array('super-admin', explode(", ", $role))
                || in_array('manager', explode(", ", $role))
            )
            <a href="{{ route('admin.jobs.create') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.add_job")}}</a>
        @endif

        <a href="{{ route('admin.settings') }}" class="text-gray-700 hover:text-blue-600 font-medium">{{__("menu.settings")}}</a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="cursor: pointer;"
                class="text-red-500 hover:underline text-left">{{__("menu.logout")}}</button>
        </form>

        <ul>
            <li><a href="{{ route('lang.switch', 'en') }}">EN</a></li>
            <li><a href="{{ route('lang.switch', 'hy') }}">AM</a></li>
            <li><a href="{{ route('lang.switch', 'ru') }}">Ru</a></li>
        </ul>
    </nav>
</aside>
