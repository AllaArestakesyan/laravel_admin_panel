@extends("layouts.app")

@section("title", "User Edit")

@section("content")
    <main class="flex-1 p-10">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>

        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Name</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="border p-2 w-full">
            </div>

            <div>
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update</button>
        </form>
    </main>
@endsection

@section('role')
    {{ auth()->user()->getRoleNames()->first() }}
@endsection