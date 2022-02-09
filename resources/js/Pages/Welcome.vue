<template>
  <Head title="Welcome" />

  <FrontLayout>
    <main class="max-w-6xl mx-auto mt-6 min-h-screen">
      <section
        class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
      >
        <div
          class="
            m-2
            p-2
            text-2xl
            font-bold
            text-indigo-600
            dark:text-indigo-300
          "
        >
          <h1>Movies</h1>
        </div>
        <div
          class="
            grid grid-cols-2
            sm:grid-cols-3
            md:grid-cols-4
            lg:grid-cols-6
            gap-4
            rounded
          "
        >
          <MovieCard v-for="movie in movies" :key="movie.id">
            <template #image>
              <Link :href="`movies/${movie.slug}`">
                <div class="aspect-w-2 aspect-h-3">
                  <img
                    class="object-cover"
                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`"
                  />
                </div>
                <div
                  class="
                    absolute
                    x-10
                    left-2
                    top-2
                    h-6
                    w-12
                    bg-gray-800
                    group-hover:bg-gray-700
                    text-blue-400 text-center
                    rounded
                  "
                >
                  New
                </div>
                <div
                  class="
                    absolute
                    inset-0
                    z-10
                    bg-gradient-to-t
                    from-black
                    to-transparent
                  "
                ></div>
                <div
                  class="
                    absolute
                    inset-y-0
                    left-5
                    z-10
                    invisible
                    group-hover:visible
                    flex
                    items-center
                  "
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-12 w-12 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>

                  <div
                    class="
                      absolute
                      transition
                      opacity-0
                      duration-500
                      ease-in-out
                      transform
                      group-hover:opacity-100
                      group-hover:translate-x-16
                      group-hover:pr-2
                      text-white
                      font-bold
                    "
                  >
                    Play
                  </div>
                </div>
                <div
                  class="
                    absolute
                    flex
                    flex-wrap
                    z-10
                    bottom-2
                    left-2
                    text-indigo-300 text-sm
                    font-bold
                    group-hover:text-blue-700
                  "
                >
                    <span class="mr-1" v-for="genre in movie.genres" :key="genre.id">
                        {{ genre.title }}
                    </span>
                </div>
              </Link>
            </template>

            <Link :href="`movies/${movie.slug}`">
              <div class="dark:text-white font-bold group-hover:text-blue-400">
                {{ movie.title }}
              </div>
            </Link>
          </MovieCard>
        </div>
      </section>

      <section
        class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
      >
        <div
          class="
            m-2
            p-2
            text-2xl
            font-bold
            text-indigo-600
            dark:text-indigo-300
          "
        >
          <h1>Tv Shows</h1>
        </div>
        <div
          class="
            grid grid-cols-2
            sm:grid-cols-3
            md:grid-cols-4
            lg:grid-cols-6
            gap-4
            rounded
          "
        >
          <MovieCard v-for="tvShow in tvShows" :key="tvShow.id">
            <template #image>
              <Link :href="`/tv-shows/${tvShow.slug}`">
                <div class="aspect-w-2 aspect-h-3">
                  <img
                    class="object-cover"
                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${tvShow.poster_path}`"
                  />
                </div>
                <div
                  class="
                    absolute
                    inset-0
                    z-10
                    bg-gradient-to-t
                    from-black
                    to-transparent
                  "
                ></div>

                <div
                  class="
                    absolute
                    x-10
                    left-2
                    top-2
                    h-6
                    w-12
                    bg-gray-800
                    group-hover:bg-gray-700
                    text-blue-400 text-center
                    rounded
                  "
                >
                  New
                </div>
                <div
                  class="
                    absolute
                    z-10
                    bottom-2
                    left-2
                    text-indigo-300 text-sm
                    font-bold
                    group-hover:text-blue-700
                  "
                >
                  {{ tvShow.seasons_count }} Season/s
                </div>
              </Link>
            </template>
            <Link :href="`/tv-shows/${tvShow.slug}`">
              <div class="dark:text-white font-bold group-hover:text-blue-400">
                {{ tvShow.name }}
              </div>
            </Link>
          </MovieCard>
        </div>
      </section>

      <section
        class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
      >
        <div
          class="
            m-2
            p-2
            text-2xl
            font-bold
            text-indigo-600
            dark:text-indigo-300
          "
        >
          <h1>Episodes</h1>
        </div>
        <div
          class="
            grid grid-cols-2
            sm:grid-cols-3
            md:grid-cols-4
            lg:grid-cols-6
            gap-4
            rounded
          "
        >
          <MovieCard v-for="episode in episodes" :key="episode.id">
            <template #image>
              <Link :href="`episodes/${episode.slug}`">
                <div class="aspect-w-2 aspect-h-3">
                  <img
                    class="object-cover"
                    :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${episode.season.poster_path}`"
                  />
                  <div
                    class="
                      absolute
                      left-0
                      top-0
                      h-8
                      w-12
                      bg-gray-800
                      text-blue-400 text-center
                    "
                  >
                    New
                  </div>
                </div>
              </Link>
            </template>
            <Link :href="`episodes/${episode.slug}`">
              <div class="dark:text-white font-bold group-hover:text-blue-400">
                {{ episode.name }}
              </div>
            </Link>
          </MovieCard>
        </div>
      </section>
    </main>
  </FrontLayout>
</template>

<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";

export default defineComponent({
  components: {
    Head,
    Link,
    FrontLayout,
    MovieCard,
  },

  props: {
    movies: Array,
    tvShows: Array,
    episodes: Array,
  },
});
</script>
