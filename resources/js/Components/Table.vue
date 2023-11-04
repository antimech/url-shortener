<script setup>
defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="(value, key) in items[0]" scope="col" class="px-6 py-3">
                        {{ key }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" class="border-b bg-white hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-500 dark:border-gray-700">
                    <th v-for="value in item" scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ value }}
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</template>
