<template>
  <FrontLayout>
    <main class="my-2" v-if="movie">
      <section class="bg-gradient-to-r from-indigo-700 to-transparent">
        <div class="max-w-6xl mx-auto m-4 p-2">
          <div class="flex">
            <div class="w-3/12">
              <div class="w-full">
                <img
                  class="w-full h-full rounded"
                  :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`"
                />
              </div>
            </div>
            <div class="w-8/12">
              <div class="m-4 p-6">
                <h1 class="flex text-white font-bold text-4xl">
                  {{ movie.title }}
                </h1>
                <div class="flex p-3 text-white space-x-4">
                  <span>{{ movie.release_date }}</span>
                  <span class="ml-2 space-x-1">
                    <template v-for="genre in movieGenres" :key="genre.id">
                      <Link
                        class="font-bold hover:text-blue-500"
                        :href="route('genres.show', genre.slug)"
                      >
                        {{ genre.title }},
                      </Link>
                    </template>
                  </span>
                  <span class="flex space-x-2">
                    {{ movie.runtime }}
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </span>
                </div>
                <div class="flex space-x-4">
                  <button
                    class="
                      px-4
                      py-2
                      text-sm
                      font-medium
                      text-white
                      bg-black
                      rounded-md
                      bg-opacity-20
                      hover:bg-opacity-30
                      focus:outline-none
                      focus-visible:ring-2
                      focus-visible:ring-white
                      focus-visible:ring-opacity-75
                    "
                    @click="openModal(trailer)"
                    v-for="trailer in trailers"
                    :key="trailer.id"
                  >
                    {{ trailer.name }}
                  </button>
                </div>
              </div>
              <div class="p-8 text-white">
                <p>{{ movie.overview }}</p>
              </div>
            </div>
          </div>
          <div class="flex space-x-4 mt-4">
            <a
              class="
                inline-flex
                justify-center
                px-4
                py-2
                text-sm
                font-medium
                text-blue-900
                bg-blue-100
                border border-transparent
                rounded-md
                hover:bg-blue-200
                focus:outline-none
                focus-visible:ring-2
                focus-visible:ring-offset-2
                focus-visible:ring-blue-500
              "
              v-for="download in downloads"
              :key="download.id"
              :href="download.web_url"
              target="_blank"
            >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
</svg>
              {{ download.name }}
            </a>
          </div>
        </div>
      </section>

      <section
        class="max-w-6xl mx-auto bg-gray-200 dark:bg-gray-900 p-2 rounded"
      >
        <div class="flex justify-between">
          <div class="w-7/12">
            <h1 class="flex text-slate-600 dark:text-white font-bold text-xl">
              Movie Casts
            </h1>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
              <MovieCard v-for="cast in casts" :key="cast.id">
                <template #image>
                  <Link :href="route('casts.show', cast.slug)">
                    <img
                      class=""
                      :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${cast.poster_path}`"
                    />
                  </Link>
                </template>
                <Link :href="route('casts.show', cast.slug)">
                  <span class="text-white">{{ cast.name }}</span>
                </Link>
              </MovieCard>
            </div>
          </div>
          <div class="w-4/12">
            <h1
              class="flex text-slate-600 dark:text-white font-bold text-xl mb-4"
            >
              Latest movies
            </h1>
            <div class="grid grid-cols-3 gap-2" v-if="latests.length">
              <Link
                v-for="latestMovie in latests"
                :key="latestMovie.id"
                :href="route('movies.show', latestMovie.slug)"
              >
                <img
                  class="w-full h-full rounded-lg"
                  :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${latestMovie.poster_path}`"
                />
              </Link>
            </div>
          </div>
        </div>
      </section>

      <section
        v-if="tags"
        class="
          max-w-6xl
          mx-auto
          bg-gradient-to-r
          from-indigo-700
          to-transparent
          mt-6
          p-2
        "
      >
        <span
          v-for="tag in tags"
          class="font-bold text-white hover:text-indigo-200 cursor-pointer"
        >
          <Link class="ml-2" :href="route('tags.show', tag.slug)"
            >#{{ tag.tag_name }}</Link
          >
        </span>
      </section>
    </main>
  </FrontLayout>

  <!-- Moadal Headless UI -->
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal">
      <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="min-h-screen px-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <DialogOverlay class="fixed inset-0" />
          </TransitionChild>

          <span class="inline-block h-screen align-middle" aria-hidden="true">
            &#8203;
          </span>

          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <div
              class="
                inline-block
                w-full
                max-w-6xl
                p-6
                my-8
                overflow-hidden
                text-left
                align-middle
                transition-all
                transform
                bg-white
                shadow-xl
                rounded-2xl
              "
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                {{ movie.title }} Trailer
              </DialogTitle>
              <div class="mt-2" v-if="modalTrailer">
                <div
                  class="aspect-w-16 aspect-h-9"
                  v-html="modalTrailer.embed_html"
                ></div>
              </div>

              <div class="mt-4">
                <button
                  type="button"
                  class="
                    inline-flex
                    justify-center
                    px-4
                    py-2
                    text-sm
                    font-medium
                    text-blue-900
                    bg-blue-100
                    border border-transparent
                    rounded-md
                    hover:bg-blue-200
                    focus:outline-none
                    focus-visible:ring-2
                    focus-visible:ring-offset-2
                    focus-visible:ring-blue-500
                  "
                  @click="closeModal"
                >
                  Close
                </button>
              </div>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import FrontLayout from "@/Layouts/FrontLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogOverlay,
  DialogTitle,
} from "@headlessui/vue";

export default {
  components: {
    Head,
    Link,
    FrontLayout,
    MovieCard,
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
    DialogTitle,
    ButtonLink,
  },

  props: {
    movie: Object,
    latests: Array,
    movieGenres: Array,
    casts: Array,
    tags: Array,
    trailers: Array,
    downloads: Array,
  },

  data() {
    return {
      isOpen: false,
      modalTrailer: null,
    };
  },

  methods: {
    closeModal() {
      this.isOpen = false;
    },
    openModal(trailer) {
      this.modalTrailer = trailer;
      this.isOpen = true;
    },
  },
};
</script>

<style>
</style>