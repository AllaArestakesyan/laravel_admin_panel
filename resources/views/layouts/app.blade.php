<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>@yield("title")</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex">
    @php
        $roles = auth()->user()->getRoleNames(); 
        $roleString = $roles->isNotEmpty() ? implode(", ", $roles->toArray()) : ''; 
    @endphp
    <!-- Sidebar -->
    @include("partials.nav", ['role' => $roleString])

    <!-- Main content -->

    @yield("content")

</body>

</html>