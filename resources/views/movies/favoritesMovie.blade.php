@extends('layout')

@section('title', __('favoritesMovie.title'))

@section('body')

    <div class="container mx-auto mt-5 max-w-5xl px-4 pb-5 xl:px-0">

        <h1 class="text-2xl font-bold">{{ __('favoritesMovie.title') }}</h1>
        <h3 class="text-gray-600 mt-2 mb-5">
            {{ __('favoritesMovie.description') }}
        </h3>

        @if ($favorites->isEmpty())
            <div class="mt-4 text-gray-500 text-center h-screen flex items-center justify-center">
                {{ __('favoritesMovie.empty') }}
            </div>
        @else
            <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 xl:gap-4">

                @foreach ($favorites as $favorite)
                    <a href="{{ url(app()->getLocale() . '/movies/' . $favorite->imdb_id) }}"
                        class="block rounded-lg border bg-white shadow-sm hover:shadow-lg transition-shadow duration-300">

                        <div class="aspect-[2/3] w-full overflow-hidden bg-gray-200">
                            <img src="{{ $favorite->poster_path }}" class="w-full h-full object-cover" loading="lazy">
                        </div>

                        <div class="p-3">
                            <h3 class="text-sm font-semibold leading-tight line-clamp-2 text-gray-800">
                                {{ $favorite->title }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-xs text-gray-500 ">
                                    {{ $favorite->release_date ?? '-' }}
                                </p>

                                <p class="text-xs text-gray-500 bg-gray-200 px-1 py-1 rounded ">{{ ucfirst($favorite->type ?? '-') }}</p>
                            </div>


                        </div>

                    </a>
                @endforeach

            </div>

        @endif

    </div>

@endsection
