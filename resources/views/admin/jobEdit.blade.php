@extends("layouts.app")

@section("title", "Edit job")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-2xl font-bold mb-4">{{__("admin.edit")}} {{__("admin.job")}}</h1>

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

        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">{{__("admin.title")}}</label>
                <input type="text" name="title" value="{{ old('name', $job->title) }}" class="border p-2 w-full">
            </div>

            <div>
                <label class="block">{{__("admin.description")}}</label>
                <textarea type="text" name="description" style="resize:none"
                    class="border p-2 w-full">{{ old('name', $job->description) }}</textarea>
            </div>

            <div>
                <label class="block">{{__("admin.budget")}}</label>
                <input type="number" name="budget" value="{{ old('name', $job->budget) }}"
                    class="border p-2 w-full"></input>
            </div>
            <div>
                <label class="block">{{__("admin.skills")}}</label>

                <select name="skills[]" id="skills" multiple
                    class="border block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($skills as $skill)
                        <option value="{{ $skill->id }}" @if ($job->skills->contains('id', $skill->id)) disabled @endif>
                            {{ $skill->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="bg-blue-500 text-white px-4 py-2">{{__("admin.update")}}</button>
        </form>


        <form action="{{ route('admin.jobs.skills.remove', $job->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <label for="skills">{{__("admin.remove_job_skills")}}</label>
            <select name="skills[]" id="skills" multiple
                class="border block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach ($job->skills as $skill)
                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="mt-3 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                {{__("admin.delete")}}
            </button>
        </form>
    </main>
@endsection
