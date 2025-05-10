@extends("layouts.app")

@section("title", "Adit Skill")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-2xl font-bold mb-4">{{__("admin.edit")}} {{__("admin.skill")}}</h1>

        <form action="{{ route('admin.skills.update', $skill->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">{{__("admin.name")}}</label>
                <input type="text" name="name" value="{{ old('name', $skill->name) }}" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2">{{__("admin.update")}}</button>
        </form>

    </main>
@endsection
