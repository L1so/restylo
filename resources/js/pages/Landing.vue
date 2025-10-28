<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <div class="container mx-auto px-4 py-12">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">
          ReStylo
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Your personal AI stylist that crafts perfect outfit recommendations based on current weather conditions and your daily events.
        </p>
      </div>

      <!-- Main Content Card -->
      <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <!-- Weather Display Section -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-700 dark:to-indigo-800 p-8 text-white">
          <div class="flex items-center justify-center flex-col space-y-4">
            <!-- Weather Icon -->
            <div class="flex items-center justify-center">
              <div class="text-8xl">
                <!-- Sunny Weather Icon -->
                <div v-if="weatherState === 'sunny'" class="w-32 h-32 relative">
                  <svg class="w-32 h-32 text-yellow-300 animate-spin-slow drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"/>
                  </svg>
                </div>

                <!-- Cloudy Weather Icon -->
                <div v-else-if="weatherState === 'cloudy'" class="w-32 h-32 relative">
                  <svg class="w-32 h-32 text-gray-300 animate-float drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4.5 9.75a6 6 0 0111.573-2.226 3.75 3.75 0 014.133 4.303A4.5 4.5 0 0118 20.25H6.75a5.25 5.25 0 01-2.23-10.004 6.072 6.072 0 01-.02-.496z" clip-rule="evenodd" />
                  </svg>
                </div>

                <!-- Rainy Weather Icon -->
                <div v-else-if="weatherState === 'rainy'" class="w-32 h-32 relative">
                  <svg class="w-32 h-32 text-blue-400 animate-bounce-gentle drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4.5 9.75a6 6 0 0111.573-2.226 3.75 3.75 0 014.133 4.303A4.5 4.5 0 0118 20.25H6.75a5.25 5.25 0 01-2.23-10.004 6.072 6.072 0 01-.02-.496z" clip-rule="evenodd" />
                  </svg>
                  <!-- Rain drops -->
                  <div class="absolute top-24 left-6 w-1 h-4 bg-blue-400 rounded-full animate-rain-1"></div>
                  <div class="absolute top-24 left-12 w-1 h-4 bg-blue-400 rounded-full animate-rain-2"></div>
                  <div class="absolute top-24 left-18 w-1 h-4 bg-blue-400 rounded-full animate-rain-3"></div>
                  <div class="absolute top-24 left-24 w-1 h-4 bg-blue-400 rounded-full animate-rain-1"></div>
                </div>

                <!-- Snowy Weather Icon -->
                <div v-else-if="weatherState === 'snowy'" class="w-32 h-32 relative">
                  <svg class="w-32 h-32 text-blue-200 animate-float drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4.5 9.75a6 6 0 0111.573-2.226 3.75 3.75 0 014.133 4.303A4.5 4.5 0 0118 20.25H6.75a5.25 5.25 0 01-2.23-10.004 6.072 6.072 0 01-.02-.496z" clip-rule="evenodd" />
                  </svg>
                  <!-- Snowflakes -->
                  <div class="absolute top-24 left-8 text-white animate-snow-1">❄</div>
                  <div class="absolute top-26 left-16 text-white animate-snow-2">❅</div>
                  <div class="absolute top-24 left-20 text-white animate-snow-3">❄</div>
                </div>

                <!-- Default/Loading Icon -->
                <div v-else class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center animate-pulse">
                  <svg class="w-16 h-16 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Weather Description -->
            <div class="text-center">
              <h2 class="text-2xl font-semibold mb-2">
                {{ weatherDescription || 'Loading weather...' }}
              </h2>
              <div v-if="temperature" class="text-lg opacity-90">
                {{ temperature }}°C ({{ Math.round(temperature * 9/5 + 32) }}°F)
              </div>
              <div v-if="location" class="text-sm opacity-75 mt-1">
                {{ location }}
              </div>
            </div>
          </div>
        </div>

        <!-- Event Input Section -->
        <div class="p-8 space-y-6">
          <div class="text-center">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
              What kind of event are you going to today?
            </h3>
            
            <!-- Event Input -->
            <div class="max-w-md mx-auto space-y-4">
              <div class="relative">
                <input
                  v-model="eventInput"
                  type="text"
                  placeholder="e.g., work meeting, casual lunch, date night..."
                  class="w-full px-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg 
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                         focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                         placeholder-gray-500 dark:placeholder-gray-400
                         transition-all duration-200"
                  @keyup.enter="getOutfitSuggestion"
                />
              </div>
              
              <!-- Get Suggestion Button -->
              <button
                @click="getOutfitSuggestion"
                :disabled="loading || !eventInput.trim()"
                class="w-full px-6 py-3 text-lg font-semibold text-white 
                       bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400
                       rounded-lg transition-all duration-200 transform
                       hover:scale-105 disabled:scale-100 disabled:cursor-not-allowed
                       focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                       shadow-lg hover:shadow-xl"
              >
                <span v-if="!loading" class="flex items-center justify-center space-x-2">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                  <span>Get Outfit Suggestion</span>
                </span>
                <span v-else class="flex items-center justify-center space-x-2">
                  <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span>Getting your perfect outfit...</span>
                </span>
              </button>
            </div>
          </div>

          <!-- Outfit Suggestion Display -->
          <div v-if="outfitSuggestion || error" class="mt-8">
            <!-- Error Display -->
            <div v-if="error" class="max-w-2xl mx-auto p-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
              <div class="flex items-center space-x-3">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <div>
                  <h4 class="text-lg font-semibold text-red-800 dark:text-red-200">Something went wrong</h4>
                  <p class="text-red-700 dark:text-red-300">{{ error }}</p>
                </div>
              </div>
            </div>

            <!-- Outfit Display -->
            <div v-else-if="outfitSuggestion" class="max-w-2xl mx-auto">
              <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 
                          border border-green-200 dark:border-green-800 rounded-lg p-6">
                <div class="flex items-center space-x-3 mb-4">
                  <div class="p-2 bg-green-100 dark:bg-green-800 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  <h4 class="text-xl font-semibold text-green-800 dark:text-green-200">
                    Your Perfect Outfit
                  </h4>
                </div>
                
                <div class="prose prose-green dark:prose-invert max-w-none">
                  <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ outfitSuggestion }}
                  </div>
                </div>

                <!-- Try Again Button -->
                <div class="mt-6 pt-4 border-t border-green-200 dark:border-green-700">
                  <button
                    @click="resetForm"
                    class="inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium text-green-700 dark:text-green-300
                           bg-white dark:bg-gray-800 border border-green-300 dark:border-green-600 rounded-md
                           hover:bg-green-50 dark:hover:bg-green-900/50 transition-colors duration-200"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Try another event</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="mt-12 text-center text-gray-500 dark:text-gray-400">
        <p class="text-sm">
          Powered by WeatherAPI.com and Google Gemini AI
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'

// Reactive state
const eventInput = ref('')
const loading = ref(false)
const error = ref<string | null>(null)
const weatherData = ref<any>(null)
const outfitSuggestion = ref<string | null>(null)

// Computed properties
const weatherState = computed(() => {
  if (!weatherData.value?.weather?.condition) return null
  
  const condition = weatherData.value.weather.condition.toLowerCase()
  
  // Map weather conditions to WeatherSvg states
  if (condition.includes('sunny') || condition.includes('clear')) {
    return 'sunny'
  } else if (condition.includes('cloud') || condition.includes('overcast')) {
    return 'cloudy'
  } else if (condition.includes('rain') || condition.includes('drizzle') || condition.includes('shower')) {
    return 'rainy'
  } else if (condition.includes('snow') || condition.includes('sleet') || condition.includes('blizzard')) {
    return 'snowy'
  } else if (condition.includes('thunder') || condition.includes('storm')) {
    return 'rainy' // Use rainy for storms as it's closest
  } else if (condition.includes('fog') || condition.includes('mist')) {
    return 'cloudy' // Use cloudy for fog/mist
  } else if (condition.includes('wind')) {
    return 'cloudy' // Use cloudy for windy conditions
  }
  
  return 'cloudy' // Default fallback
})

const weatherDescription = computed(() => {
  return weatherData.value?.weather?.condition || null
})

const temperature = computed(() => {
  return weatherData.value?.weather?.temperature_c || null
})

const location = computed(() => {
  const loc = weatherData.value?.weather?.location
  if (!loc) return null
  
  const parts = [loc.name, loc.region, loc.country].filter(Boolean)
  return parts.join(', ')
})

// Methods
const getOutfitSuggestion = async () => {
  if (!eventInput.value.trim()) return
  
  loading.value = true
  error.value = null
  outfitSuggestion.value = null
  
  try {
    const response = await fetch(`/api/outfit?event=${encodeURIComponent(eventInput.value.trim())}`)
    
    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || `HTTP ${response.status}`)
    }
    
    const data = await response.json()
    weatherData.value = data
    outfitSuggestion.value = data.suggestion
    
  } catch (err: any) {
    error.value = err.message || 'Failed to get outfit suggestion. Please try again.'
    console.error('Error fetching outfit suggestion:', err)
  } finally {
    loading.value = false
  }
}

const resetForm = () => {
  eventInput.value = ''
  outfitSuggestion.value = null
  error.value = null
}

// Load initial weather data on mount
const loadInitialWeather = async () => {
  try {
    const response = await fetch('/api/outfit?event=casual')
    if (response.ok) {
      const data = await response.json()
      weatherData.value = data
    }
  } catch (err) {
    console.warn('Failed to load initial weather data:', err)
  }
}

onMounted(() => {
  loadInitialWeather()
})
</script>

<style scoped>
/* Custom animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes spin-slow {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
}

@keyframes bounce-gentle {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-5px);
  }
}

@keyframes rain-drop {
  0% {
    transform: translateY(0px);
    opacity: 1;
  }
  100% {
    transform: translateY(20px);
    opacity: 0;
  }
}

@keyframes snow-fall {
  0% {
    transform: translateY(0px) rotate(0deg);
    opacity: 1;
  }
  100% {
    transform: translateY(20px) rotate(360deg);
    opacity: 0;
  }
}

.animate-fade-in-up {
  animation: fadeInUp 0.6s ease-out;
}

.animate-spin-slow {
  animation: spin-slow 8s linear infinite;
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

.animate-bounce-gentle {
  animation: bounce-gentle 2s ease-in-out infinite;
}

.animate-rain-1 {
  animation: rain-drop 1.5s linear infinite;
}

.animate-rain-2 {
  animation: rain-drop 1.5s linear infinite 0.3s;
}

.animate-rain-3 {
  animation: rain-drop 1.5s linear infinite 0.6s;
}

.animate-snow-1 {
  animation: snow-fall 3s linear infinite;
}

.animate-snow-2 {
  animation: snow-fall 3s linear infinite 1s;
}

.animate-snow-3 {
  animation: snow-fall 3s linear infinite 2s;
}
</style>