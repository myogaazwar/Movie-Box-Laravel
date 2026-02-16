<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Movie Box - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/movies.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>


<body>
    @if (auth()->check())
        <nav class="w-full px-4 py-3 shadow-sm sticky top-0 bg-white z-10 border-b ">
            <div class="flex items-center justify-between max-w-5xl mx-auto">
                <a class="font-bold text-xl" href="{{ route('movies', app()->getLocale()) }}">
                    Movie Box
                </a>

                <div class="flex items-center gap-4">
                    <a class="py-2 px-3 rounded-lg text-black {{ request()->routeIs('movies') ? 'bg-gray-200 ' : '' }}"
                        href="{{ route('movies', app()->getLocale()) }}">
                        {{ __('navbar.btn_movies') }}
                    </a>
                    <a class="py-2 px-3 rounded-lg text-black {{ request()->routeIs('movies.favorites') ? 'bg-gray-200 ' : '' }}"
                        href="{{ route('movies.favorites', app()->getLocale()) }}">
                        {{ __('navbar.btn_favorites') }}
                    </a>

                    <form action="{{ route('logout', app()->getLocale()) }}" method="POST" class="d-inline">
                        @csrf
                        <button
                            class="bg-red-500 text-white py-2 px-3 rounded-lg">{{ __('navbar.btn_logout') }}</button>
                    </form>
                </div>
            </div>
        </nav>
    @endif


    <main class="min-h-screen bg-[#F2EBE5]">
        @yield('body')


    </main>

    @php
        $currentLocale = app()->getLocale();
        $newLocale = $currentLocale === 'id' ? 'en' : 'id';
    @endphp

    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">

        <div x-show="open" x-transition @click.away="open = false" class="mb-3 flex flex-col items-center gap-2">

            <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['locale' => $newLocale])) }}"
                class="w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:scale-110 transition border">

                <img src="{{ asset($currentLocale === 'id' ? 'flagCountry/united-kingdom.png' : 'flagCountry/indonesia-flag.png') }}"
                    class="w-7 h-7 rounded-full">
            </a>
        </div>

        <button @click="open = !open"
            class="w-14 h-14 bg-white rounded-full shadow-lg 
                   flex items-center justify-center
                   hover:scale-110 transition-all duration-300
                   border">

            <img src="{{ asset($currentLocale === 'id' ? 'flagCountry/indonesia-flag.png' : 'flagCountry/united-kingdom.png') }}"
                class="w-8 h-8 rounded-full">
        </button>

    </div>


</body>

</html>
