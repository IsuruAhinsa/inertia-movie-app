<template>
  <Head :title="`${episode.name} - ${season.name}`" />

  <FrontLayout>
    <main class="my-2" v-if="episode">
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
                  {{ episode.name }}
                </h1>
                <div class="flex text-white space-x-4">
                  <span>Episode Number: {{ episode.episode_number }}</span>
                  <span>Season: {{ season.name }}</span>
                </div>
                <hr>
                <div class="text-white">
                <p>{{ episode.overview }}</p>
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
          <div class="w-full">
            <h1 class="flex text-slate-600 dark:text-white font-bold text-xl">
              Latest Episodes
            </h1>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
              <MovieCard v-for="latestEpisode in latests" :key="latestEpisode.id">
                <template #image>
                  <Link :href="route('episodes.show', latestEpisode.slug)">
                    <img
                      class=""
                      :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${season.poster_path}`"
                    />
                  </Link>
                </template>
                <Link :href="route('episodes.show', latestEpisode.slug)">
                  <span class="text-white">{{ latestEpisode.name }}</span>
                </Link>
              </MovieCard>
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
    season: Object,
    latests: Array,
    episode: Array,
  },
};
</script>