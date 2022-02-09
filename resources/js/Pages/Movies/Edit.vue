<template>
  <admin-layout title="Edit Movie">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Movie
      </h2>
    </template>

    <section class="mx-auto p-6">
      <form @submit.prevent="updateMovie">
        <div>
          <jet-label for="title" value="Title" />
          <jet-input
            id="title"
            type="text"
            class="mt-1 block w-full"
            v-model="form.title"
          />
          <jet-input-error :message="form.errors.title" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="release_date" value="Release Date" />
          <jet-input
            id="release_date"
            type="date"
            class="mt-1 block w-full"
            v-model="form.release_date"
          />
          <jet-input-error :message="form.errors.release_date" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="runtime" value="Runtime" />
          <jet-input
            id="runtime"
            type="text"
            class="mt-1 block w-full"
            v-model="form.runtime"
          />
          <jet-input-error :message="form.errors.runtime" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="lang" value="Language" />
          <jet-input
            id="lang"
            type="text"
            class="mt-1 block w-full"
            v-model="form.lang"
          />
          <jet-input-error :message="form.errors.lang" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="video_format" value="Video Format" />
          <jet-input
            id="video_format"
            type="text"
            class="mt-1 block w-full"
            v-model="form.video_format"
          />
          <jet-input-error :message="form.errors.video_format" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="rating" value="Rating" />
          <jet-input
            id="rating"
            type="number"
            step="any"
            class="mt-1 block w-full"
            v-model="form.rating"
          />
          <jet-input-error :message="form.errors.rating" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="poster_path" value="Poster Path" />
          <jet-input
            id="poster_path"
            type="text"
            class="mt-1 block w-full"
            v-model="form.poster_path"
          />
          <jet-input-error :message="form.errors.poster_path" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="backdrop_path" value="Backdrop Path" />
          <jet-input
            id="backdrop_path"
            type="text"
            class="mt-1 block w-full"
            v-model="form.backdrop_path"
          />
          <jet-input-error :message="form.errors.backdrop_path" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="overview" value="Overview" />
          <text-area
            id="overview"
            class="mt-1 block w-full"
            v-model="form.overview"
          ></text-area>
          <jet-input-error :message="form.errors.overview" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="is_public">
            <div class="flex items-center">
              <jet-checkbox
                name="is_public"
                id="is_public"
                v-model:checked="form.is_public"
              />
              <div class="ml-2">
                Public
              </div>
            </div>
          </jet-label>
          <jet-input-error :message="form.errors.is_public" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <jet-button
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Update Movie
          </jet-button>
        </div>
      </form>
    </section>
  </admin-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";

export default defineComponent({
  components: {
    AdminLayout,
    JetButton,
    JetInput,
    JetSecondaryButton,
    JetLabel,
    Link,
    JetInputError,
    TextArea,
    JetCheckbox
  },

  props: {
    movie: Object,
  },

  setup(props) {
    const form = useForm({
      title: props.movie.title,
      release_date: props.movie.release_date,
      runtime: props.movie.runtime,
      lang: props.movie.lang,
      video_format: props.movie.video_format,
      rating: props.movie.rating,
      poster_path: props.movie.poster_path,
      backdrop_path: props.movie.backdrop_path,
      overview: props.movie.overview,
      is_public: props.movie.is_public ? true : false,
    });

    function updateMovie() {
      form.put(
        `/admin/movies/${props.movie.id}`
      );
    }

    return { form, updateMovie };
  },
});
</script>
