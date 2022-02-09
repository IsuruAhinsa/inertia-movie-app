<template>
    <admin-layout title="Edit Season">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Season
            </h2>
        </template>

        <section class="mx-auto p-6">
            <form @submit.prevent="updateSeason">
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
                    <jet-label for="season_number" value="Season Number" />
                    <jet-input
                        id="season_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.season_number"
                    />
                    <jet-input-error :message="form.errors.season_number" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-label for="poster_path" value="Poster" />
                    <jet-input
                        id="poster_path"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.poster_path"
                    />
                    <jet-input-error :message="form.errors.poster_path" class="mt-2" />
                </div>

                

                <div class="flex items-center justify-end mt-4">
                    <jet-button
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Update Season
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
import JetInputError from '@/Jetstream/InputError.vue'

export default defineComponent({
    components: {
        AdminLayout,
        JetButton,
        JetInput,
        JetSecondaryButton,
        JetLabel,
        Link,
        JetInputError,
    },

    props: {
        tvShow: Object,
        season: Object,
    },

    setup(props) {
        const form = useForm({
            name: props.season.name,
            season_number: props.season.season_number,
            poster_path: props.season.poster_path,
        });

        function updateSeason() {
            form.put(`/admin/tv-shows/${props.tvShow.id}/seasons/${props.season.id}`);
        }

        return { form, updateSeason };
    },
});
</script>
