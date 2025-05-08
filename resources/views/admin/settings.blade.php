@extends("layouts.app")

@section("title", "Settings")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Settings</h1>

        {{-- Success Message --}}
        @if (session('success'))
            <div x-data="{ show1: true }" x-show="show1"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative">
                <span>{{ session('success') }}</span>

                <button @click="show1 = false" class="absolute top-2 right-2 text-green-700 hover:text-green-900 font-bold"
                    aria-label="Close">
                    &times;
                </button>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div x-data="{ show2: true }" x-show="show2"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative">
                <span>{{ session('error') }}</span>

                <button @click="show2 = false" class="absolute top-2 right-2 text-red-700 hover:text-red-900 font-bold"
                    aria-label="Close">
                    &times;
                </button>
            </div>
        @endif


        <form action="{{ route('admin.settings.update', auth()->user()->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update</button>
        </form>


        <h3 class="text-3xl font-bold text-gray-800 mb-6">Update Password</h3>
        <form action="{{ route('admin.settings.updatePassword', auth()->user()->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Old password</label>
                <input type="password" name="old_password" class="border p-2 w-full">
            </div>
            <div>
                <label class="block">Password</label>
                <input type="password" name="password" class="border p-2 w-full">
            </div>
            <div>
                <label class="block">Confirm password</label>
                <input type="password" name="confirm_password" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update</button>
        </form>
    </main>
@endsection
