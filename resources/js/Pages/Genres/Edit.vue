<template>
    <admin-layout title="Edit Genre">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Genre
            </h2>
        </template>

        <section class="mx-auto p-6">
            <form @submit.prevent="updateGenre">
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

                <div class="flex items-center justify-end mt-4">
                    <jet-button
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Update Genre
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
        genre: Object
    },

    setup(props) {
        const form = useForm({
            title: props.genre.title,
        });

        function updateGenre() {
            form.put("/admin/genres/" + props.genre.id);
        }

        return { form, updateGenre };
    },
});
</script>
