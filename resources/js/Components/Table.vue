<template>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <slot name="tableHead"></slot>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <slot />
        </tbody>
    </table>
</template>

<script>
export default {};
</script>

<style></style>
