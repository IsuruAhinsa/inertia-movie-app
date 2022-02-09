<template>
    <admin-layout title="Create Tag">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Tag
            </h2>
        </template>

        <section class="mx-auto p-6">
            <form @submit.prevent="storeTag">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="block">
                            <label
                                for="tag-name"
                                class="block text-sm font-medium text-gray-700"
                                >Tag Name</label
                            >
                            <input
                                v-model="form.tagName"
                                type="text"
                                name="tag-name"
                                id="tag-name"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            />
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Save
                        </button>
                    </div>
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
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default defineComponent({
    components: {
        AdminLayout,
        JetButton,
        JetInput,
        JetSecondaryButton,
        Link,
    },

    setup() {
        const form = useForm({
            tagName: '',
        })

        function storeTag() {
            form.post('/admin/tags');
        }

        return { form, storeTag }
    },
});
</script>
