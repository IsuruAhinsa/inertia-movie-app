<template>
    <admin-layout title="Casts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Casts
            </h2>
        </template>

        <section class="mx-auto p-6">
            <div class="w-full flex mb-4 p-2 justify-end">
                <form
                    class="flex space-x-4 items-center shadow bg-white rounded-md m-2 p-2"
                >
                    <div class="p-1 flex items-center">
                        <label
                            for="tmdb_id_g"
                            class="block text-sm font-medium text-gray-700 mr-4"
                            >Cast Tmdb Id</label
                        >
                        <div class="relative rounded-md shadow-sm">
                            <jet-input
                                type="text"
                                v-model="castTMDBId"
                                id="tmdb_id_g"
                                placeholder="Cast ID"
                            />
                        </div>
                    </div>
                    <div class="p-1">
                        <jet-button type="button" @click="generateCast"
                            >Generate</jet-button
                        >
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
                            placeholder="Search by name"
                            class="px-8 py-3 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
                        />
                    </div>

                    <select
                        v-model="perPage"
                        @change="getCasts"
                        class="px-4 py-3 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm"
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
                            class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                        >
                            <Table>
                                <template #tableHead>
                                    <TableHead>Name</TableHead>
                                    <TableHead>Slug</TableHead>
                                    <TableHead>Poster</TableHead>
                                    <TableHead>Action</TableHead>
                                </template>
                                <TableRow
                                    v-for="cast in casts.data"
                                    :key="cast.id"
                                >
                                    <TableData>{{ cast.name }}</TableData>
                                    <TableData>{{ cast.slug }}</TableData>
                                    <TableData>{{ cast.poster_path }}</TableData>
                                    <TableData class="space-x-2">
                                        <ButtonLink class="bg-green-500 hover:bg-green-700" :route="route('admin.casts.edit',cast.id)">
                                            Edit
                                        </ButtonLink>
                                        <ButtonLink method="delete"
                                            as="button"
                                            type="button" class="bg-red-500 hover:bg-red-700" :route="route('admin.casts.destroy',cast.id)">
                                            Delete
                                        </ButtonLink>
                                    </TableData>
                                </TableRow>
                            </Table>
                        </div>
                    </div>
                </div>

                <pagination :links="casts.links" />
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
        casts: Object,
        filters: Object,
    },

    data() {
        return {
            search: this.filters.search,
            perPage: 5,
            castTMDBId: null,
        };
    },

    watch: {
        search(value) {
            this.$inertia.get(
                "/admin/casts",
                { search: value, perPage: this.perPage },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },
    },

    methods: {
        getCasts() {
            this.$inertia.get(
                "/admin/casts",
                { perPage: this.perPage, search: this.search },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        },

        generateCast() {
            this.$inertia.post(
                "/admin/casts",
                { castTMDBId: this.castTMDBId },
                {
                    onFinish: () => (this.castTMDBId = ""),
                }
            );
        },
    },
});
</script>
