<template>
  <div class="relative pointer-events-auto">
    <button
      v-bind="$attrs"
      @click="openModal"
      type="button"
      class="
        w-52
        md:w-72
        flex
        items-center
        text-sm
        leading-6
        text-gray-400
        rounded-md
        ring-1 ring-gray-900/10
        shadow-sm
        py-1.5
        pl-2
        pr-3
        hover:ring-gray-300
        dark:bg-gray-700 dark:highlight-white/5 dark:hover:bg-gray-900
      "
    >
      <svg
        width="24"
        height="24"
        fill="none"
        aria-hidden="true"
        class="mr-3 flex-none"
      >
        <path
          d="m19 19-3.5-3.5"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></path>
        <circle
          cx="11"
          cy="11"
          r="6"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        ></circle></svg
      >Quick search...<span class="ml-auto pl-3 flex-none text-xs font-semibold"
        >⌘K</span
      >
    </button>
  </div>

  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog
      class="fixed inset-0 z-50 flex justify-center items-start"
      @close="closeModal"
    >
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
            flex flex-col
            overflow-hidden
            z-0
            w-full
            max-w-xl
            bg-white
            dark:bg-slate-900
            rounded-lg
            mx-4
            max-h-[80vh]
            relative
          "
        >
          <form class="relative flex items-center m-2">
            <div
              class="
                absolute
                inset-y-0
                left-0
                flex
                items-center
                pl-4
                pointer-events-none
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                />
              </svg>
            </div>
            <input
              @input="(e) => search(e.target.value)"
              type="text"
              class="
                w-full
                py-4
                pl-12
                border-b
                bg-gray-50
                border-gray-100
                dark:text-slate-300 dark:border-gray-700 dark:bg-slate-700
                focus:border-none
                outline-none
                placeholder-gray-400
                rounded-lg
              "
              placeholder="Search"
            />
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
              <button>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5 text-gray-400"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </div>
          </form>
          <div class="overflow-hidden">
            <div
              v-if="isLoading"
              class="
                shadow
                rounded-md
                p-4
                w-full
                mx-auto
              "
            >
              <div class="animate-pulse flex space-x-4">
                <div class="flex-1 space-y-6 py-1">
                  <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                      <div class="h-2 bg-slate-200 rounded col-span-2"></div>
                      <div class="h-2 bg-slate-200 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-slate-200 rounded"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <ul v-if="results.length > 0 && !isLoading" class="m-2">
            <li
              v-for="item in results"
              :key="item.id"
              class="flex items-center px-4 py-2.5 relative rounded-lg"
            >
              <Link class="flex space-x-2 hover:text-blue-500" :href="item.url">
                <div>{{ item.title }}</div>
                <span>{{ item.type }}</span>
                </Link>
            </li>
          </ul>
          <p v-if="results.length === 0 && isLoading" class="p-10 text-center text-gray-400">
            Sorry! No Results...
          </p>
        </div>
      </TransitionChild>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
// Thi
import axios from "axios";
import { debounce } from "lodash";
import { ref } from "@vue/reactivity";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogOverlay,
  DialogTitle,
} from "@headlessui/vue";
import { Link } from "@inertiajs/inertia-vue3";

const isOpen = ref(false);
const isLoading = ref(false);
const results = ref([]);

const search = debounce(async (term) => {
  isLoading.value = true;
  let { data } = await axios.get("/api/search", { params: { search: term } });
  results.value = data;
  isLoading.value = false;
}, 250);

function closeModal() {
  isOpen.value = false;
  isLoading.value = false;
}

function openModal() {
  isOpen.value = true;
}
</script>

<style>
</style>