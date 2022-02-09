<template>
    <div class="flex justify-start py-1">
        <template v-for="(link, key) in links">
            <div
                class="bg-gray-100 border leading-4 px-3 py-1 mx-1 text-sm text-gray-400 rounded cursor-not-allowed"
                v-if="link.url === null"
                v-html="link.label"
            ></div>
            <Link
                v-else
                class="bg-gray-100 border leading-4 px-3 py-1 mx-1 text-sm text-gray-400 rounded cursor-pointer focus:text-indigo-500 focus:border-indigo-500 hover:bg-white"
                :key="key"
                :href="link.url"
                v-html="link.label"
                :class="{ 'bg-indigo-200': link.active }"
            />
        </template>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import { defineComponent } from "vue";

export default defineComponent({

    components: {
        Link,
    },

    props: {
        links: Array,
    },

});
</script>

<style></style>
