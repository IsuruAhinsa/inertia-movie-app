<template>
  <admin-layout title="Movie Attachments">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Movie Attachments
      </h2>
    </template>

    <section class="p-6 bg-white m-4 rounded shadow-sm">
      <div class="flex space-x-2 mb-4">
        <div v-for="trailer in trailers" :key="trailer.id">
          <ButtonLink
            :route="route('admin.trailers.destroy', trailer.id)"
            method="delete"
            as="button"
            type="button"
            class="hover:bg-red-500 focus:bg-red-700"
          >
            {{ trailer.name }}
          </ButtonLink>
        </div>
      </div>

      <form @submit.prevent="attachTrailer">
        <div>
          <jet-label for="name" value="Name" />
          <jet-input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
          />
          <jet-input-error :message="form.errors.name" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="embed_html" value="Embed" />
          <text-area
            id="embed_html"
            class="mt-1 block w-full"
            v-model="form.embed_html"
          ></text-area>
          <jet-input-error :message="form.errors.embed_html" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <jet-button
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Attach Trailer
          </jet-button>
        </div>
      </form>
    </section>

    <section class="p-6 bg-white m-4 rounded shadow-sm">
      <div class="flex space-x-2 mb-4">
        <div v-for="download in downloads" :key="download.id">
          <ButtonLink
            :route="route('admin.downloads.destroy', download.id)"
            method="delete"
            as="button"
            type="button"
            class="hover:bg-red-500 focus:bg-red-700"
          >
            {{ download.name }}
          </ButtonLink>
        </div>
      </div>

      <form @submit.prevent="attachDownload">
        <div>
          <jet-label for="name" value="Name" />
          <jet-input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="downloadForm.name"
          />
          <jet-input-error :message="downloadForm.errors.name" class="mt-2" />
        </div>

        <div class="mt-4">
          <jet-label for="web_url" value="Web URL" />
          <text-area
            id="web_url"
            class="mt-1 block w-full"
            v-model="downloadForm.web_url"
          ></text-area>
          <jet-input-error
            :message="downloadForm.errors.web_url"
            class="mt-2"
          />
        </div>

        <div class="flex items-center justify-end mt-4">
          <jet-button
            class="ml-4"
            :class="{ 'opacity-25': downloadForm.processing }"
            :disabled="downloadForm.processing"
          >
            Attach Download
          </jet-button>
        </div>
      </form>
    </section>

    <section class="p-6 bg-white m-4 rounded shadow-sm">
      <div class="flex space-x-2 mb-4">
        <div v-for="movieCast in movieCasts" :key="movieCast.id">
          <span
            class="
              flex
              justify-center
              items-center
              m-1
              font-medium
              py-1
              px-2
              rounded-full
              text-green-700
              bg-green-100
              border border-green-300
            "
          >
            <span
              class="text-xs font-normal leading-none max-w-full flex-initial"
            >
              {{ movieCast.name }}
            </span>
          </span>
        </div>
      </div>

      <div>
        <form @submit.prevent="attachCasts">
          <multiselect
            v-model="castForm.casts"
            :options="casts"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :preserve-search="true"
            placeholder="Attach Cast"
            label="name"
            track-by="name"
          ></multiselect>

          <div class="flex items-center justify-end mt-4">
            <jet-button
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Attach Casts
            </jet-button>
          </div>
        </form>
      </div>
    </section>

    <section class="p-6 bg-white m-4 rounded shadow-sm">
      <div class="flex space-x-2 mb-4">
        <div v-for="movieTag in movieTags" :key="movieTag.id">
          <span
            class="
              flex
              justify-center
              items-center
              m-1
              font-medium
              py-1
              px-2
              rounded-full
              text-green-700
              bg-green-100
              border border-green-300
            "
          >
            <span
              class="text-xs font-normal leading-none max-w-full flex-initial"
            >
              {{ movieTag.tag_name }}
            </span>
          </span>
        </div>
      </div>

      <div>
        <form @submit.prevent="attachTags">
          <multiselect
            v-model="tagForm.tags"
            :options="tags"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :preserve-search="true"
            placeholder="Attach Tag"
            label="tag_name"
            track-by="tag_name"
          ></multiselect>

          <div class="flex items-center justify-end mt-4">
            <jet-button
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Attach Tags
            </jet-button>
          </div>
        </form>
      </div>
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
import JetInputError from "@/Jetstream/InputError.vue";
import TextArea from "@/Components/TextArea.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import Multiselect from "vue-multiselect";

export default defineComponent({
  components: {
    AdminLayout,
    JetButton,
    JetInput,
    JetLabel,
    Link,
    JetInputError,
    TextArea,
    JetCheckbox,
    ButtonLink,
    Multiselect,
  },

  props: {
    movie: Object,
    trailers: Array,
    casts: Array,
    tags: Array,
    movieCasts: Array,
    movieTags: Array,
    downloads: Array,
  },

  setup(props) {
    const form = useForm({
      name: "",
      embed_html: "",
    });

    const castForm = useForm({
      casts: props.movieCasts,
    });

    const tagForm = useForm({
      tags: props.movieTags,
    });

    const downloadForm = useForm({
      name: "",
      web_url: "",
    });

    function attachTrailer() {
      form.post(`/admin/movies/${props.movie.id}/add-trailer`, {
        onSuccess: () => form.reset(),
      });
    }

    function attachDownload() {
      downloadForm.post(`/admin/movies/${props.movie.id}/add-download`, {
        onSuccess: () => downloadForm.reset(),
      });
    }

    function attachCasts() {
      castForm.post(`/admin/movies/${props.movie.id}/add-casts`, {
        preserveState: true,
        preserveScroll: true,
      });
    }

    function attachTags() {
      tagForm.post(`/admin/movies/${props.movie.id}/add-tags`, {
        preserveState: true,
        preserveScroll: true,
      });
    }

    return { form, attachTrailer, castForm, attachCasts, tagForm, attachTags, downloadForm, attachDownload };
  },
});
</script>


<style src="vue-multiselect/dist/vue-multiselect.css"></style>