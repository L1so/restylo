<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-6">
    <main class="w-full max-w-3xl p-8 bg-white dark:bg-gray-800 rounded-xl shadow">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">ReStylo</h1>
      <p class="mt-4 text-gray-600 dark:text-gray-300">Daily outfit recommendations tailored to your local weather and events — powered by WeatherAPI and Google Gemini.</p>

      <div class="mt-6 flex items-center gap-3">
        <label for="event" class="sr-only">Event</label>
        <select v-model="event" id="event" class="px-3 py-2 border rounded">
          <option value="casual">Casual</option>
          <option value="formal">Formal</option>
          <option value="sport">Sport</option>
          <option value="business">Business</option>
        </select>

        <button @click="getOutfit" :disabled="loading" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-60">
          <span v-if="!loading">Get outfit suggestion</span>
          <span v-else>Loading...</span>
        </button>
      </div>

      <div class="mt-6">
        <template v-if="error">
          <div class="text-red-600">Error: {{ error }}</div>
        </template>

        <template v-else-if="result">
          <div class="rounded border p-4 bg-gray-50 dark:bg-gray-900">
            <h2 class="font-semibold">Weather</h2>
            <pre class="text-sm">{{ result.weather }}</pre>

            <h2 class="mt-3 font-semibold">Prompt</h2>
            <div class="text-sm whitespace-pre-wrap">{{ result.prompt }}</div>

            <h2 class="mt-3 font-semibold">Suggestion</h2>
            <div class="mt-2 text-sm whitespace-pre-wrap">{{ result.suggestion }}</div>
          </div>
        </template>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const event = ref('casual')
const loading = ref(false)
const error = ref<string | null>(null)
const result = ref<any>(null)

async function getOutfit() {
  loading.value = true
  error.value = null
  result.value = null

  try {
    const res = await fetch(`/api/outfit?event=${encodeURIComponent(event.value)}`)
    if (!res.ok) {
      const text = await res.text()
      throw new Error(text || `HTTP ${res.status}`)
    }
    result.value = await res.json()
  } catch (err: any) {
    error.value = err.message || String(err)
  } finally {
    loading.value = false
  }
}

// Export refs for template
defineExpose({ event, loading, error, result, getOutfit })
</script>

<style scoped>
/* small local styles if needed */
</style>
