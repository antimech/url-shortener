<script setup>
import { ref, onMounted } from 'vue';
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Table from "@/Components/Table.vue";
import InputError from "@/Components/InputError.vue";
import CopyButton from "@/Components/CopyButton.vue";

// reactive state
const link = ref('');
const customAlias = ref('');
const expiredAt = ref('');
const shortLinks = ref([]);
const shortLink = ref('');
const errors = ref([]);

// functions that mutate state and trigger updates
async function handleSubmit() {
    const formData = {
        'link': link.value,
        'custom_alias': customAlias.value,
        'expired_at': expiredAt.value,
    };

    try {
        const {data: { data }} = await axios.post(route('link.store'), formData);
        shortLink.value = data.short_link;
        shortLinks.value.push({
            'Short Link': data.short_link,
            'Link': data.link,
            'Expired At': data.expired_at,
        });
    } catch (error) {
        errors.value = error.response.data.errors;
    }

    clearFields();
}

function clearFields() {
    link.value = '';
    customAlias.value = '';
    expiredAt.value = '';
    errors.value = [];
}

// lifecycle hooks
onMounted(() => {
    console.log('Component mounted.');
});
</script>

<template>
    <form>
        <div>
            <TextInput
                id="link"
                type="text"
                class="mt-1 block w-full"
                v-model="link"
                required
                autofocus
                placeholder="Paste your link here..."
            />

            <InputError v-if="errors.link" class="mt-2" :message="errors.link[0]" />
        </div>

        <div>
            <TextInput
                id="custom_alias"
                type="text"
                class="mt-1 block w-full"
                v-model="customAlias"
                placeholder="Custom link (optional)"
            />

            <InputError v-if="errors.custom_alias" class="mt-2" :message="errors.custom_alias[0]" />
        </div>

        <div>
            <TextInput
                id="expired_at"
                type="datetime-local"
                class="mt-1 block w-full"
                v-model="expiredAt"
                placeholder="Expiration date (optional)"
            />

            <InputError v-if="errors.expired_at" class="mt-2" :message="errors.expired_at[0]" />
        </div>

        <div class="flex justify-center pt-2">
            <PrimaryButton @click.prevent="handleSubmit">Shorten</PrimaryButton>
        </div>
    </form>

    <p v-if="shortLink" class="text-center pt-2">
        <a
            v-bind:href="shortLink"
            target="_blank"
            class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >
            {{ shortLink }}
        </a>

        <CopyButton :text="shortLink" />
    </p>

    <Table v-if="shortLink" :items="shortLinks" class="pt-2" />
</template>
