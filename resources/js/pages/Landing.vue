<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <div class="container mx-auto px-4 py-12">
      <!-- Header -->
      <div class="text-center mb-12 onboarding-welcome-target">
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
              <div class="relative onboarding-event-input">
                <input
                  v-model="eventInput"
                  type="text"
                  placeholder="e.g., work meeting, casual lunch, date night..."
                  class="w-full px-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg 
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                         focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                         placeholder-gray-500 dark:placeholder-gray-400
                         transition-all duration-200"
                  @keyup.enter="handleOutfitSuggestion"
                  @input="handleEventInputChange"
                />
              </div>
              
              <!-- Optional Location Override -->
              <div class="relative onboarding-location-input">
                <input
                  v-model="locationInput"
                  type="text"
                  placeholder="Location (optional) - e.g., Jakarta, Indonesia"
                  class="w-full px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg 
                         bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                         focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                         placeholder-gray-500 dark:placeholder-gray-400
                         transition-all duration-200"
                  @keyup.enter="handleOutfitSuggestion"
                />
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                  Leave empty to use your current location
                </div>
              </div>
              
              <!-- Get Suggestion Button -->
              <button
                @click="handleOutfitSuggestion"
                :disabled="loading || !eventInput.trim()"
                class="onboarding-submit-button w-full px-6 py-3 text-lg font-semibold text-white 
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

            <!-- Visual Outfit Display -->
            <div v-else-if="outfitSuggestion" class="onboarding-results-target max-w-lg mx-auto">
              <!-- Header -->
              <div class="text-center mb-8">
                <div class="flex items-center justify-center space-x-3 mb-4">
                  <div class="p-2 bg-green-100 dark:bg-green-800 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </div>
                  <h4 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Your Perfect Outfit
                  </h4>
                </div>
                <p class="text-gray-600 dark:text-gray-400">
                  Curated for {{ weatherDescription?.toLowerCase() || 'current' }} weather
                </p>
              </div>

              <!-- Outfit Items -->
              <div class="space-y-4">
                <!-- Shirt/Top -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">
                  <div class="flex flex-col items-center space-y-4">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl flex items-center justify-center border border-blue-200 dark:border-blue-800">
                      <!-- Shirt/Top SVG Icon -->
                      <svg class="w-16 h-16 text-blue-500 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 4l3.86 1.93L20 8l-1 1h-1v11c0 .55-.45 1-1 1H7c-.55 0-1-.45-1-1V9H5l-1-1l.14-2.07L8 4l2-2h4l2 2zm-2 0v1h-4V4h4zm4 5v11H6V9h12z"/>
                      </svg>
                    </div>
                    <div class="text-center">
                      <h5 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Top</h5>
                      <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ cleanMarkdown(parsedOutfit.shirt) || 'Comfortable top suitable for the weather' }}
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Pants/Bottom -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">
                  <div class="flex flex-col items-center space-y-4">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl flex items-center justify-center border border-green-200 dark:border-green-800">
                      <!-- Pants/Bottom SVG Icon -->
                      <svg class="w-16 h-16 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 2v5.2L5.5 9H3L5 22h4l2-10 2 10h4l2-13h-2.5L16 7.2V2H8zm6 3v2h-4V5h4z"/>
                      </svg>
                    </div>
                    <div class="text-center">
                      <h5 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Bottom</h5>
                      <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ cleanMarkdown(parsedOutfit.pants) || 'Appropriate bottom wear for the occasion' }}
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Shoes -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl hover:scale-[1.02]">
                  <div class="flex flex-col items-center space-y-4">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-50 to-red-100 dark:from-orange-900/20 dark:to-red-900/20 rounded-xl flex items-center justify-center border border-orange-200 dark:border-orange-800">
                      <!-- Shoes SVG Icon -->
                      <svg class="w-16 h-16 text-orange-500 dark:text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M2 18h20l-.5-2H21c0-1-1-3-3-3s-3 2-3 3h-6c0-1-1-3-3-3s-3 2-3 3h-.5L2 18zm0 2v1c0 .5.5 1 1 1h18c.5 0 1-.5 1-1v-1H2z"/>
                      </svg>
                    </div>
                    <div class="text-center">
                      <h5 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Shoes</h5>
                      <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ cleanMarkdown(parsedOutfit.shoes) || 'Weather-appropriate footwear' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Full AI Response (Collapsible) -->
              <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <button
                  @click="showFullResponse = !showFullResponse"
                  class="w-full flex items-center justify-center space-x-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition-colors duration-200"
                >
                  <span>{{ showFullResponse ? 'Hide' : 'Show' }} detailed recommendations</span>
                  <svg 
                    class="w-4 h-4 transition-transform duration-200"
                    :class="{ 'rotate-180': showFullResponse }"
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>
                
                <div 
                  v-show="showFullResponse"
                  class="mt-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700"
                >
                  <div 
                    class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap"
                    v-html="formatOutfitText(outfitSuggestion)"
                  ></div>
                </div>
              </div>

              <!-- Try Again Button -->
              <div class="mt-8 text-center">
                <button
                  @click="resetForm"
                  class="inline-flex items-center space-x-2 px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300
                         bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg
                         hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm hover:shadow-md"
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

      <!-- Footer -->
      <div class="mt-12 text-center text-gray-500 dark:text-gray-400">
        <p class="text-sm mb-4">
          Powered by WeatherAPI.com and Google Gemini AI
        </p>
        <!-- Onboarding restart button (for testing) -->
        <button
          v-if="onboarding.isCompleted.value"
          @click="onboarding.resetTour(); onboarding.startTour()"
          class="text-xs text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 underline"
        >
          Restart Tutorial
        </button>
      </div>
    </div>

    <!-- Onboarding Tour -->
    <OnboardingTour
      :is-active="onboarding.isActive.value"
      :current-step="onboarding.currentStep.value"
      :current-step-index="onboarding.currentStepIndex.value"
      :steps="onboarding.steps.value"
      :progress="onboarding.progress.value"
      :is-first-step="onboarding.isFirstStep.value"
      :is-last-step="onboarding.isLastStep.value"
      @next-step="onboarding.nextStep"
      @previous-step="onboarding.previousStep"
      @skip-tour="onboarding.skipTour"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import OnboardingTour from '../components/OnboardingTour.vue'
import { useOnboarding } from '../composables/useOnboarding'

// Reactive state
const eventInput = ref('')
const locationInput = ref('')
const loading = ref(false)
const error = ref<string | null>(null)
const weatherData = ref<any>(null)
const outfitSuggestion = ref<string | null>(null)
const showFullResponse = ref(false)
const parsedOutfit = ref<{
  shirt: string | null
  pants: string | null
  shoes: string | null
}>({
  shirt: null,
  pants: null,
  shoes: null
})

// Initialize onboarding
const onboarding = useOnboarding()

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
const parseOutfitSuggestion = (suggestion: string) => {
  // Reset parsed outfit
  parsedOutfit.value = { shirt: null, pants: null, shoes: null }
  
  if (!suggestion) return
  
  // Clean and normalize the suggestion text
  const cleanSuggestion = suggestion
    .replace(/\*\*/g, '') // Remove markdown bold
    .replace(/^\s*[-*•]\s*/gm, '') // Remove bullet points
  
  const lines = cleanSuggestion.split('\n')
  
  for (const line of lines) {
    const trimmedLine = line.trim()
    if (!trimmedLine) continue
    
    // Look for clothing categories with improved parsing
    if (/^(top|shirt|blouse):/i.test(trimmedLine)) {
      const colonIndex = trimmedLine.indexOf(':')
      if (colonIndex !== -1) {
        const item = trimmedLine.substring(colonIndex + 1).trim()
        if (item) parsedOutfit.value.shirt = item
      }
    } else if (/^(bottom|pants|trousers|skirt|jeans):/i.test(trimmedLine)) {
      const colonIndex = trimmedLine.indexOf(':')
      if (colonIndex !== -1) {
        const item = trimmedLine.substring(colonIndex + 1).trim()
        if (item) parsedOutfit.value.pants = item
      }
    } else if (/^(shoes|footwear|sandals|sneakers|boots):/i.test(trimmedLine)) {
      const colonIndex = trimmedLine.indexOf(':')
      if (colonIndex !== -1) {
        const item = trimmedLine.substring(colonIndex + 1).trim()
        if (item) parsedOutfit.value.shoes = item
      }
    }
  }
  
  // Fallback parsing for less structured responses
  if (!parsedOutfit.value.shirt) {
    // Look for top/shirt descriptions in various formats
    const shirtPatterns = [
      /(?:wear|choose|try)\s+(?:a\s+)?([^.\n]*(?:shirt|top|blouse|tee|polo)[^.\n]*?)(?:\.|,|\n|$)/i,
      /(?:shirt|top|blouse|tee)[\s:]*([^.\n]*?)(?:\.|,|\n|and)/i,
      /([^.\n]*(?:cotton|linen|silk|denim)[^.\n]*(?:shirt|top|blouse)[^.\n]*)/i
    ]
    
    for (const pattern of shirtPatterns) {
      const match = cleanSuggestion.match(pattern)
      if (match && match[1]) {
        parsedOutfit.value.shirt = match[1].trim()
        break
      }
    }
  }
  
  if (!parsedOutfit.value.pants) {
    const pantsPatterns = [
      /(?:wear|choose|try)\s+(?:a\s+)?([^.\n]*(?:pants|jeans|trousers|skirt|shorts)[^.\n]*?)(?:\.|,|\n|$)/i,
      /(?:pants|jeans|trousers|skirt|shorts)[\s:]*([^.\n]*?)(?:\.|,|\n|and)/i,
      /([^.\n]*(?:wide-leg|cropped|midi|chinos)[^.\n]*(?:pants|jeans|trousers|skirt)[^.\n]*)/i
    ]
    
    for (const pattern of pantsPatterns) {
      const match = cleanSuggestion.match(pattern)
      if (match && match[1]) {
        parsedOutfit.value.pants = match[1].trim()
        break
      }
    }
  }
  
  if (!parsedOutfit.value.shoes) {
    const shoesPatterns = [
      /(?:wear|choose|try)\s+(?:a\s+)?([^.\n]*(?:shoes|sandals|sneakers|boots|flats)[^.\n]*?)(?:\.|,|\n|$)/i,
      /(?:shoes|sandals|sneakers|boots|flats|footwear)[\s:]*([^.\n]*?)(?:\.|,|\n|and)/i,
      /([^.\n]*(?:comfortable|strappy|leather)[^.\n]*(?:shoes|sandals|sneakers|boots)[^.\n]*)/i
    ]
    
    for (const pattern of shoesPatterns) {
      const match = cleanSuggestion.match(pattern)
      if (match && match[1]) {
        parsedOutfit.value.shoes = match[1].trim()
        break
      }
    }
  }
  
  // Clean up the parsed items
  Object.keys(parsedOutfit.value).forEach(key => {
    const item = parsedOutfit.value[key as keyof typeof parsedOutfit.value]
    if (item) {
      // Remove leading/trailing punctuation and clean up
      parsedOutfit.value[key as keyof typeof parsedOutfit.value] = item
        .replace(/^[,\-\s]+|[,\-\s]+$/g, '')
        .replace(/\s+/g, ' ')
        .trim()
    }
  })
}

// Handle outfit suggestion with onboarding integration
const handleOutfitSuggestion = async () => {
  // If onboarding is active and we're on the submit button step, advance to results step
  if (onboarding.isActive.value && onboarding.currentStep.value?.id === 'submit-button') {
    await getOutfitSuggestion()
    // Wait a moment for the UI to update, then advance to results step
    setTimeout(() => {
      if (outfitSuggestion.value) {
        onboarding.nextStep()
      }
    }, 500)
  } else {
    await getOutfitSuggestion()
  }
}

const getOutfitSuggestion = async () => {
  if (!eventInput.value.trim()) return
  
  loading.value = true
  error.value = null
  outfitSuggestion.value = null
  parsedOutfit.value = { shirt: null, pants: null, shoes: null }
  
  try {
    // Build API URL with parameters
    const params = new URLSearchParams({
      event: eventInput.value.trim()
    })
    
    // Add location parameter if specified
    if (locationInput.value.trim()) {
      params.append('location', locationInput.value.trim())
    }
    
    const response = await fetch(`/api/outfit?${params.toString()}`)
    
    if (!response.ok) {
      const errorText = await response.text()
      throw new Error(errorText || `HTTP ${response.status}`)
    }
    
    const data = await response.json()
    weatherData.value = data
    outfitSuggestion.value = data.suggestion
    
    // Parse the outfit suggestion into visual components
    parseOutfitSuggestion(data.suggestion)
    
  } catch (err: any) {
    error.value = err.message || 'Failed to get outfit suggestion. Please try again.'
    console.error('Error fetching outfit suggestion:', err)
  } finally {
    loading.value = false
  }
}

// Format markdown-style text to HTML
const formatOutfitText = (text: string | null): string => {
  if (!text) return ''
  
  return text
    // Convert **bold** to <strong>bold</strong>
    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
    // Convert *italic* to <em>italic</em>
    .replace(/(?<!\*)\*(?!\*)([^*]+)(?<!\*)\*(?!\*)/g, '<em>$1</em>')
    // Convert line breaks to <br> tags
    .replace(/\n/g, '<br>')
    // Clean up any remaining asterisks that might be formatting artifacts
    .replace(/^\*\s*/gm, '• ')
}

// Clean markdown formatting from plain text (for individual outfit items)
const cleanMarkdown = (text: string | null): string => {
  if (!text) return ''
  
  return text
    // Remove **bold** markers but keep the text
    .replace(/\*\*(.*?)\*\*/g, '$1')
    // Remove *italic* markers but keep the text
    .replace(/(?<!\*)\*(?!\*)([^*]+)(?<!\*)\*(?!\*)/g, '$1')
    // Clean up any remaining asterisks
    .replace(/^\*\s*/gm, '')
    .trim()
}

const resetForm = () => {
  eventInput.value = ''
  locationInput.value = ''
  outfitSuggestion.value = null
  showFullResponse.value = false
  parsedOutfit.value = { shirt: null, pants: null, shoes: null }
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

// Helper method to advance onboarding when user types
const handleEventInputChange = () => {
  // If onboarding is active and we're on the event input step, auto-advance after user types
  if (onboarding.isActive.value && onboarding.currentStep.value?.id === 'event-input' && eventInput.value.trim().length > 3) {
    setTimeout(() => {
      onboarding.nextStep()
    }, 1000) // Give user time to read what they typed
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