@extends("layouts.app")

@section("title", "Admin Profile")

@section("content")
    <main class="flex-1 p-10">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">{{__("admin.create_admin")}}</h2>

            @if ($errors->any())
                <div class="text-red-500 text-sm mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">{{__("admin.name")}}</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">{{__("admin.email")}}</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">{{__("admin.password")}}</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label for="Confirm-password" class="block text-sm font-semibold text-gray-700">{{__("admin.confirm_password")}}</label>
                    <input type="password" name="confirm_password" required
                        class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700">{{__("admin.role")}}</label>
                    <select name="role" required
                        class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">{{__("admin.select_role")}}</option>
                        <option value="admin">{{__("admin.admin")}}</option>
                        <option value="manager">{{__("admin.manager")}}</option>
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md transition duration-200"

                    >
                    {{__("admin.save")}}
                </button>
            </form>
        </div>
    </main>
@endsection
