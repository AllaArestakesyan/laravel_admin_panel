@extends("layouts.app")

@section("title", "Create Jobs")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-2xl font-bold mb-4">Create Job</h1>

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

        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf

            <div>
                <label class="block">Title</label>
                <input type="text" name="title" class="border p-2 w-full"  >
            </div>

            <div>
                <label class="block">Description</label>
                <textarea type="text" style="resize:none" name="description" class="border p-2 w-full"></textarea>
            </div>

            <div>
                <label class="block">Budget</label>
                <input type="number" name="budget" class="border p-2 w-full"></input>
            </div>

            <div>
                <label class="block">Skills</label>

                <select name="skills[]" id="skills" multiple
                    class="border block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($skills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>


            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Save</button>
        </form>

    </main>
@endsection
