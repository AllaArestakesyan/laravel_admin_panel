@extends("layouts.app")

@section("title", "Admin Edit")

@section("content")
    <main class="flex-1 p-10">
        <h2 class="text-xl font-bold mb-4">Edit Admin </h2>

        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Name</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="border p-2 w-full">
            </div>

            <div>
                <label for="role">Role:</label>
                <select name="role" id="role" class="border rounded px-3 py-2">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Update</button>
        </form>
    </main>
@endsection
