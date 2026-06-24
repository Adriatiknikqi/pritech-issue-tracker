<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Issue Tracker</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
                <a href="{{ route('projects.index') }}" class="font-bold text-xl">
                    Mini Issue Tracker
                </a>

                <div class="flex gap-4">
                    <a href="{{ route('projects.index') }}" class="text-blue-600 hover:underline">
                        Projects
                    </a>
                    <a href="{{ route('issues.index') }}" class="text-blue-600 hover:underline">
                        Issues
                    </a>
                </div>
            </div>
        </nav>

        <main class="max-w-6xl mx-auto px-4 py-8">
            @if (session('success'))
            <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>