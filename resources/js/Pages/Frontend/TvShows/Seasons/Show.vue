<template>
  <Head :title="season.name" />

  <FrontLayout>
    <main class="my-2" v-if="season">
      <section class="bg-gradient-to-r from-indigo-700 to-transparent">
        <div class="max-w-6xl mx-auto m-4 p-2">
          <div class="flex">
            <div class="w-3/12">
              <div class="w-full">
                <img
                  class="w-full h-full rounded"
                  :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`"
                />
              </div>
            </div>
            <div class="w-8/12">
              <div class="m-4 p-6">
                <h1 class="flex text-white font-bold text-4xl">
                  {{ season.name }}
                </h1>
                <div class="flex p-3 text-white space-x-4">
                  <span>Season Number: {{ season.season_number }}</span>
                  <br>
                  <span>Tv Show: {{ tvShow.name }} - {{ tvShow.created_year }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section
        class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded"
      >
        <div class="flex justify-between">
          <div class="w-7/12">
            <h1 class="flex text-slate-600 dark:text-white font-bold text-xl">
              Episodes
            </h1>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
              <MovieCard v-for="episode in episodes" :key="episode.id">
                <template #image>
                  <Link :href="route('episodes.show', episode.slug)">
                    <img
                      class=""
                      :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`"
                    />
                  </Link>
                </template>
                <Link :href="route('episodes.show', episode.slug)">
                  <span class="text-white">{{ episode.name }}</span>
                </Link>
              </MovieCard>
            </div>
          </div>
          <div class="w-4/12">
            <h1
              class="flex text-slate-600 dark:text-white font-bold text-xl mb-4"
            >
              Latest Tv Shows
            </h1>
            <div class="grid grid-cols-3 gap-2" v-if="latests.length">
              <Link
                v-for="latestTvShow in latests"
                :key="latestTvShow.id"
                :href="route('tv-shows.show', latestTvShow.slug)"
              >
                <img
                  class="w-full h-full rounded-lg"
                  :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${latestTvShow.poster_path}`"
                />
              </Link>
            </div>
          </div>
        </div>
      </section>
    </main>
  </FrontLayout>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";

export default {
  components: {
    Head,
    Link,
    FrontLayout,
    MovieCard,
  },

  props: {
    tvShow: Object,
    season: Object,
    latests: Array,
    episodes: Array,
  },
};
</script>

<style>
</style>