<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobTrack — @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen">

    <nav class="border-b border-gray-800 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('applications.index') }}" class="text-xl font-bold tracking-tight text-white">
                Job<span class="text-indigo-400">Track</span>
            </a>
            @auth
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-400">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-400 hover:text-white transition">Log out</button>
                </form>
            </div>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-lg bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
