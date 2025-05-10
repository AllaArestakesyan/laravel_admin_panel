@extends("layouts.app")

@section("title", "User Edit")

@section("content")
    <main class="flex-1 p-10">
        <h2 class="text-xl font-bold mb-4">{{__("admin.edit")}} {{__("admin.user")}}</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">{{__("admin.name")}}</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2">{{__("admin.update")}}</button>
        </form>
    </main>
@endsection
