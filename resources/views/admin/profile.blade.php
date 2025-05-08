@extends("layouts.app")

@section("title", "Admin Profile")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Welcome, {{ auth()->user()->name }}</h1>

        <div class="bg-white rounded-xl shadow p-6 w-full max-w-xl">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Your Profile</h2>
            <div class="space-y-2 text-gray-600">
                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Role:</strong> {{ auth()->user()->getRoleNames()->first() }}</p>
            </div>
        </div>
    </main>
@endsection

@section('role')
    {{ auth()->user()->getRoleNames()->first() }}
@endsection