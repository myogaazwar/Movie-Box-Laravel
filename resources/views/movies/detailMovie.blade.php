@extends('layout')

@section('title', $movie['Title'])

@section('body')
    <div class=" max-w-5xl mx-auto mt-5 px-4 bg-[#FAFAFA] ">

        <a href="{{ route('movies', app()->getLocale()) }}" class="text-blue-500">{{ __('detailMovie.btn_back') }}</a>

        <div class="mt-4 flex flex-col sm:flex-row sm:gap-x-5">
            <img src="{{ $movie['Poster'] }}" class="w-full h-full sm:w-64 h-96 object-cover rounded-lg shadow-md">

            <div class="mt-5 sm:mt-0">
                <h1 class="text-2xl font-bold">
                    {{ $movie['Title'] }}
                </h1>

                <div class="flex flex-wrap items-center gap-3 mt-4">
                    <p>{{ $movie['Year'] }}</p>
                    <span>.</span>
                    <p>{{ $movie['Runtime'] }}</p>
                    <span>.</span>
                    <p>{{ $movie['Rated'] }}</p>
                </div>

                <div class="flex items-center gap-x-1 mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-6 h-6 inline-block text-yellow-400">

                        <path fill-rule="evenodd"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
                            clip-rule="evenodd" />
                    </svg>

                    <div class="flex items-center gap-x-1">
                        <p class="font-semibold text-lg">{{ $movie['imdbRating'] }}</p>
                        <p class="text-gray-400">/ 10</p>
                    </div>
                </div>

                <div class="flex items-center gap-x-2 mt-4">
                    @foreach ($genres as $genre)
                        <p class="bg-gray-200 px-3 py-1 rounded-full text-sm">
                            {{ $genre }}
                        </p>
                    @endforeach
                </div>



                <p class="mt-4">
                    {{ $movie['Plot'] }}
                </p>

                @if ($isFavorite)
                    <form method="POST"
                        action="{{ route('movies.removeFavorite', [app()->getLocale(), $movie['imdbID']]) }}">
                        @csrf
                        @method('DELETE')

                        <button class="mt-5 bg-primary text-white px-4 py-2 rounded inline-flex items-center gap-x-2">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 w-5 text-white absolute">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <span class="pl-8">
                                Remove from Favorite
                        </button>
                    </form>
                @else
                    <form method="POST"
                        action="{{ route('movies.addFavorite', [app()->getLocale(), $movie['imdbID']]) }}">
                        @csrf
                        <button class="mt-5 bg-primary text-white px-4 py-2 rounded inline-flex items-center gap-x-2">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 w-5 text-white absolute">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <span class="pl-8">
                                Add to Favorite
                        </span>
                        </button>
                     

                    </form>
                @endif


                <div class="mt-5">
                    <p>{{ __('detailMovie.director') }}: <span class="text-gray-500">{{ $movie['Director'] }}</span></p>
                    <p>{{ __('detailMovie.writer') }}: <span class="text-gray-500">{{ $movie['Writer'] }}</span></p>
                    <p>{{ __('detailMovie.cast') }}: <span class="text-gray-500">{{ $movie['Actors'] }}</span></p>
                    <p>{{ __('detailMovie.country') }}: <span class="text-gray-500">{{ $movie['Country'] }}</span></p>
                    <p>{{ __('detailMovie.language') }}: <span class="text-gray-500">{{ $movie['Language'] }}</span></p>
                    <p>{{ __('detailMovie.awards') }}: <span class="text-gray-500">{{ $movie['Awards'] }}</span></p>
                    
                </div>


            </div>




        </div>

    </div>
@endsection
