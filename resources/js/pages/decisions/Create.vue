<script setup lang="ts">
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'

const form = useForm({
    title: '',
    category: 'hiring',
    answers: []
})

const categories = ['hiring', 'partnership', 'marketing', 'personal']

function submit() {
    form.post('/decisions')
}
</script>

<template>
    <Head title="New Decision" />

    <div class="p-6 space-y-4">
        <h1 class="text-2xl font-bold">Log a New Decision</h1>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block font-medium">Title</label>
                <input v-model="form.title" type="text" class="border rounded w-full px-2 py-1" />
            </div>

            <div>
                <label class="block font-medium">Category</label>
                <select v-model="form.category" class="border rounded w-full px-2 py-1">
                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Answers (demo placeholder)</label>
                <input
                    v-model="form.answers[0]"
                    type="number"
                    class="border rounded w-full px-2 py-1"
                    placeholder="Impact score (0-100)"
                />
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Decision
            </button>
        </form>
    </div>
</template>
