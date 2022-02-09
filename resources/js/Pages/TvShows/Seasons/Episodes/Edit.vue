<template>
  <admin-layout title="Edit Episode">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Episode
      </h2>
    </template>

    <section class="mx-auto p-6">
      <form @submit.prevent="updateEpisode">
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
          <jet-label for="episode_number" value="Episode Number" />
          <jet-input
            id="episode_number"
            type="text"
            class="mt-1 block w-full"
            v-model="form.episode_number"
          />
          <jet-input-error :message="form.errors.episode_number" class="mt-2" />
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
            Update Episode
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
    tvShow: Object,
    season: Object,
    episode: Object,
  },

  setup(props) {
    const form = useForm({
      name: props.episode.name,
      episode_number: props.episode.episode_number,
      overview: props.episode.overview,
      is_public: props.episode.is_public ? true : false,
    });

    function updateEpisode() {
      form.put(
        `/admin/tv-shows/${props.tvShow.id}/seasons/${props.season.id}/episodes/${props.episode.id}`
      );
    }

    return { form, updateEpisode };
  },
});
</script>
