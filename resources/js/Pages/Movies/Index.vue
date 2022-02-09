<template>
  <admin-layout title="Movies">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Movies
      </h2>
    </template>

    <section class="mx-auto p-6">
      <div class="w-full flex mb-4 p-2 justify-end">
        <form
          class="flex space-x-4 items-center shadow bg-white rounded-md m-2 p-2"
        >
          <div class="p-1 flex items-center">
            <label
              for="movieTMDBId"
              class="block text-sm font-medium text-gray-700 mr-4"
              >Movie TMDB</label
            >
            <div class="relative rounded-md shadow-sm">
              <jet-input
                type="text"
                v-model="movieTMDBId"
                id="movieTMDBId"
                placeholder="Movie Id"
              />
            </div>
          </div>
          <div class="p-1">
            <jet-button type="button" @click="generateMovie">
              <svg
                v-show="showSpinner"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              <div>
                <span v-if="!showSpinner">Create Movie</span>
                <span v-else>Creating...</span>
              </div>
            </jet-button>
          </div>
        </form>
      </div>

      <div class="flex flex-col">
        <div class="flex justify-between py-1">
          <div class="relative">
            <div class="absolute flex items-center ml-2 h-full">
              <svg
                class="w-4 h-4 fill-current text-primary-gray-dark"
                viewBox="0 0 16 16"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z"
                ></path>
              </svg>
            </div>

            <input
              v-model="search"
              type="text"
              placeholder="Search by title"
              class="
                px-8
                py-3
                rounded-md
                bg-gray-100
                border-transparent
                focus:border-gray-500 focus:bg-white focus:ring-0
                text-sm
              "
            />
          </div>

          <select
            v-model="perPage"
            @change="getMovies"
            class="
              px-4
              py-3
              rounded-md
              bg-gray-100
              border-transparent
              focus:border-gray-500 focus:bg-white focus:ring-0
              text-sm
            "
          >
            <option :value="5">5 Per Page</option>
            <option :value="10">10 Per Page</option>
            <option :value="15">15 Per Page</option>
          </select>
        </div>

        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div
            class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
          >
            <div
              class="
                w-full
                shadow
                overflow-hidden
                border-b border-gray-200
                sm:rounded-lg
              "
            >
              <Table>
                <template #tableHead>
                  <TableHead>Title</TableHead>
                  <TableHead>Release Date</TableHead>
                  <TableHead>Runtime</TableHead>
                  <TableHead>Languages</TableHead>
                  <TableHead>Video Format</TableHead>
                  <TableHead>Public</TableHead>
                  <!-- <TableHead>Visits</TableHead> -->
                  <!-- <TableHead>Slug</TableHead> -->
                  <TableHead>Rating</TableHead>
                  <TableHead>Poster</TableHead>
                  <!-- <TableHead>Backdrop</TableHead> -->
                  <TableHead>Overview</TableHead>
                  <TableHead style="width:20%">Action</TableHead>
                </template>
                <TableRow v-for="movie in movies.data" :key="movie.id">
                  <TableData>{{ movie.title }}</TableData>
                  <TableData>{{ movie.release_date }}</TableData>
                  <TableData>{{ movie.runtime }}</TableData>
                  <TableData>{{ movie.lang }}</TableData>
                  <TableData>{{ movie.video_format }}</TableData>
                  <TableData>
                    <span v-if="movie.is_public" class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-green-700 bg-green-100 border border-green-300">
                      <span class="text-xs font-normal leading-none max-w-full flex-initial">
                        Published
                      </span>
                    </span>
                    <span v-else class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-red-700 bg-red-100 border border-red-300">
                      <span class="text-xs font-normal leading-none max-w-full flex-initial">
                        Unpublished
                      </span>
                    </span>
                  </TableData>
                  <!-- <TableData>{{ movie.visits }}</TableData> -->
                  <!-- <TableData>{{ movie.slug }}</TableData> -->
                  <TableData>{{ movie.rating }}</TableData>
                  <TableData>
                    <img class="rounded" :src="`https://www.themoviedb.org/t/p/w220_and_h330_face/${movie.poster_path}`" alt="">
                  </TableData>
                  <!-- <TableData>{{ movie.backdrop_path }}</TableData> -->
                  <TableData>{{ movie.overview }}</TableData>
                  <TableData class="space-x-2 space-y-2">
                    <ButtonLink
                      :route="route('admin.movies.attach', movie.id)"
                    >
                      Attachments
                    </ButtonLink>
                    <ButtonLink
                      class="bg-green-500 hover:bg-green-700"
                      :route="route('admin.movies.edit', movie.id)"
                    >
                      Edit
                    </ButtonLink>
                    <ButtonLink
                      method="delete"
                      as="button"
                      type="button"
                      class="bg-red-500 hover:bg-red-700"
                      :route="route('admin.movies.destroy', movie.id)"
                    >
                      Delete
                    </ButtonLink>
                  </TableData>
                </TableRow>
              </Table>
            </div>
          </div>
        </div>

        <pagination :links="movies.links" />
      </div>
    </section>
  </admin-layout>
</template>

<script>
import { defineComponent } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHead from "@/Components/TableHead.vue";
import TableData from "@/Components/TableData.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    AdminLayout,
    JetButton,
    JetInput,
    JetSecondaryButton,
    Link,
    Pagination,
    Table,
    TableRow,
    TableHead,
    TableData,
    ButtonLink,
  },

  props: {
    filters: Object,
    movies: Object,
  },

  data() {
    return {
      search: this.filters.search,
      perPage: 5,
      movieTMDBId: null,
      showSpinner: false,
    };
  },

  watch: {
    search(value) {
      this.$inertia.get(
        `/admin/movies`,
        { search: value, perPage: this.perPage },
        {
          preserveState: true,
          replace: true,
        }
      );
    },
  },

  methods: {
    getMovies() {
      this.$inertia.get(
        `/admin/movies`,
        { perPage: this.perPage, search: this.search },
        {
          preserveState: true,
          replace: true,
        }
      );
    },

    generateMovie() {
      this.$inertia.post(
        `/admin/movies`,
        { movieTMDBId: this.movieTMDBId },
        {
          onStart: () => (this.showSpinner = true),
          onFinish: () => {
            this.showSpinner = false;
            this.movieTMDBId = "";
          },
        }
      );
    },
  },
});
</script>