@extends("layouts.app")

@section("title", "Admin Profile")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('admin.welcome') }} {{ auth()->user()->name }}</h1>

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

        <div class="bg-white rounded-xl shadow p-6 w-full max-w-xl">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">{{__("admin.dashboard")}}</h2>
            <div class="space-y-2 text-gray-600">
                <p><strong>{{__("admin.name")}}:</strong> {{ auth()->user()->name }}</p>
                <p><strong>{{__("admin.email")}}:</strong> {{ auth()->user()->email }}</p>
                <p><strong>{{__("admin.role")}}:</strong> {{ implode(", ",auth()->user()->getRoleNames()->toArray())}}</p>
            </div>
        </div>
    </main>
@endsection
