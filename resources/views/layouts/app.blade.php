<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/admin') }}" class="text-xl font-bold text-gray-900">
                        Aplikasi Permohonan
                    </a>
                </div>
                <div class="flex items-center">
                    @auth
                        <span class="text-gray-700 mr-4">{{ auth()->user()->name }}</span>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if ($errors->any())
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="py-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <p class="text-gray-600 text-center">© {{ date('Y') }} Aplikasi Permohonan. All rights reserved.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
