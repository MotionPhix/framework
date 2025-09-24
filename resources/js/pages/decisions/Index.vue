<script setup lang="ts">
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps<{ decisions: Array<any> }>()
</script>

<template>
    <Head title="Decisions" />

    <div class="p-6 space-y-4">
        <h1 class="text-2xl font-bold">Your Decisions</h1>

        <Link href="/decisions/create" class="bg-blue-600 text-white px-4 py-2 rounded">
            New Decision
        </Link>

        <div v-if="decisions.length === 0" class="text-gray-500 italic">
            No decisions logged yet.
        </div>

        <ul v-else class="space-y-2">
            <li v-for="d in decisions" :key="d.id" class="border p-4 rounded">
                <h2 class="font-semibold">{{ d.title }} ({{ d.category }})</h2>
                <p class="text-sm">Score: {{ d.score }}</p>
                <p class="text-sm italic">{{ d.recommendation }}</p>
            </li>
        </ul>
    </div>
</template>
