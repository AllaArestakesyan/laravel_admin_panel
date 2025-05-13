@extends("layouts.app")

@section("title", "Users")

@section("content")
    <main class="flex-1 p-10">
        <h1 class="text-2xl font-bold mb-4">{{__("admin.users")}}</h1>

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

        <table class="min-w-full bg-white border border-gray-200 shadow">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">{{__("admin.name")}}</th>
                    <th class="px-4 py-2 border">{{__("admin.email")}}</th>
                    <th class="px-4 py-2 border">{{__("admin.register_at")}}</th>
                    @if(auth()->user()->getRoleNames()->first() == "super-admin" || auth()->user()->getRoleNames()->first() == "admin")
                        <th class="px-4 py-2 border">{{__("admin.edit")}}</th>
                    @endif
                    @if(auth()->user()->getRoleNames()->first() == "super-admin")
                        <th class="px-4 py-2 border">{{__("admin.delete")}}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $user->id }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->created_at->format('Y-m-d') }}</td>
                        @if(auth()->user()->getRoleNames()->first() == "super-admin" || auth()->user()->getRoleNames()->first() == "admin")
                            <td class="px-4 py-2 border">
                                <a href="users/{{$user->id}}/edit">
                                    <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" height="24px"
                                        viewBox="0 -960 960 960" width="24px" fill="#900">
                                        <path
                                            d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                                    </svg>
                                </a>
                            </td>
                        @endif
                        @if(auth()->user()->getRoleNames()->first() == "super-admin")
                            <td class="px-4 py-2 border">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" height="24px"
                                            viewBox="0 -960 960 960" width="24px" fill="#900">
                                            <path
                                                d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection
