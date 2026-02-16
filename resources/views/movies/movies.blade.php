@extends('layout')

@section('title', __('movies.title'))


@section('body')
    <div class="container mx-auto mt-5 max-w-5xl px-4 pb-5 xl:px-0" x-data="movieSearch('{{ $defaultQuery }}')" x-init="init()">

        <h1 class="text-2xl font-bold">{{ __('movies.title') }}</h1>
        <h3 class="text-gray-600 mt-2 mb-5">{{ __('movies.description') }}</h3>

        <div class="relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6 w-5 absolute left-3 top-3 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input type="text" x-model="query" class="pl-10 border p-2 w-full shadow-sm"
                placeholder="{{ __('movies.placeholder_search') }}">

        </div>

        <button @click="search()" class="bg-primary text-white px-8 py-2 mt-5 rounded-lg">
            {{ __('movies.btn_search') }}
        </button>



        <div x-show="loading" class="mt-4 loader">
        </div>


        <div x-show="!loading && movies.length === 0 && query" class="mt-4 text-red-500">
            {{ __('movies.error_not_found') }}
        </div>

      <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 xl:gap-4">

    <template x-for="movie in movies" :key="movie.imdbID">
        <a class="block rounded-lg border bg-white shadow-sm hover:shadow-lg transition-shadow duration-300"
           :href="'{{ url(app()->getLocale() . '/movies') }}/' + movie.imdbID">

            <div class="aspect-[2/3] w-full overflow-hidden bg-gray-200">
             <img :src="movie.Poster !== 'N/A' ? movie.Poster : 'https://placehold.co/300x450'"
                    class="w-full h-full object-cover"
                    loading="lazy">
            </div>

            <div class="p-3">
                <h3 class="text-sm font-semibold leading-tight line-clamp-2 text-gray-800"
                    x-text="movie.Title">
                </h3>

                <div class="flex items-center gap-2 mt-1">
   <p class="text-xs text-gray-500"
                   x-text="movie.Year">
                </p>
                <p class="text-xs text-gray-500 bg-gray-200 px-1 py-1 rounded"
                   x-text="movie.Type.charAt(0).toUpperCase() + movie.Type.slice(1)">
                    
                </p>
                </div>
             

            </div>

        </a>
    </template>

</div>




    </div>

   <script>
function movieSearch(defaultQuery) {
    return {
        query: defaultQuery,
        movies: [],
        loading: false,
        page: 1,
        hasMore: true,

        init() {
            this.search();

            window.addEventListener('scroll', () => {
                if ((window.innerHeight + window.scrollY) 
                    >= document.body.offsetHeight - 200) {
                    this.loadMore();
                }
            });
        },

        async search() {
            this.loading = true;
            this.page = 1;
            this.hasMore = true;

            const res = await fetch(
                `{{ route('movies.search', app()->getLocale()) }}?title=${this.query}&page=${this.page}`
            );

            const data = await res.json();

            this.movies = data.Search ?? [];
            this.hasMore = data.Search && data.Search.length > 0;
            this.loading = false;
        },

        async loadMore() {
            if (this.loading || !this.hasMore) return;

            this.loading = true;
            this.page++;

            const res = await fetch(
                `{{ route('movies.search', app()->getLocale()) }}?title=${this.query}&page=${this.page}`
            );

            const data = await res.json();

            if (!data.Search) {
                this.hasMore = false;
                this.loading = false;
                return;
            }

            this.movies = [...this.movies, ...data.Search];
            this.loading = false;
        }
    }
}
</script>

@endsection
