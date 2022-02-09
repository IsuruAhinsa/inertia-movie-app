<template>
  <textarea :value="modelValue" cols="10" style="height: 121px" class="form-textarea border-gray-300 dark:bg-dark-third dark:text-dark-typography dark:border-transparent focus:border-indigo-300 dark:focus:border-indigo-500 focus:ring dark:focus:ring-0 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm resize-none" @input="$emit('update:modelValue', $event.target.value)" ref="input"></textarea>
</template>

<script>
 import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['modelValue'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    })
</script>

<style>
</style>