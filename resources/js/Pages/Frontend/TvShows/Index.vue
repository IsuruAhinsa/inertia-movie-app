<template>
  <Head title="TV Shows" />

  <FrontLayout>
    <main class="max-w-6xl mx-auto mt-6 min-h-screen">
      <section
        class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded"
      >
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
          <MovieCard v-for="tvShow in tvShows.data" :key="tvShow.id">
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

        <div class="m-2 p-2">
            <Pagination :links="tvShows.links" />
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
import Pagination from "@/Components/Pagination.vue";

export default defineComponent({
  components: {
    Head,
    Link,
    FrontLayout,
    MovieCard,
    Pagination,
  },

  props: {
    tvShows: Array,
  },
});
</script>