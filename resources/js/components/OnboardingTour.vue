<template>
  <Teleport to="body">
    <!-- Overlay -->
    <Transition name="onboarding-overlay">
      <div
        v-if="isActive && currentStep"
        class="fixed inset-0 z-[9999] pointer-events-none"
        @click.stop
      >
        <!-- Dark overlay with spotlight effect -->
        <div class="absolute inset-0 bg-black/50">
          <!-- Spotlight hole for highlighted element -->
          <div
            v-if="spotlightStyle"
            :style="spotlightStyle"
            class="absolute bg-transparent rounded-lg shadow-[0_0_0_9999px_rgba(0,0,0,0.5)] pointer-events-auto"
          ></div>
        </div>

        <!-- Tooltip -->
        <div
          ref="tooltipRef"
          :style="tooltipStyle"
          class="absolute pointer-events-auto transform transition-all duration-300 ease-out"
          :class="tooltipClasses"
        >
          <!-- Tooltip arrow -->
          <div
            v-if="arrowStyle"
            :style="arrowStyle"
            class="absolute w-3 h-3 bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700 transform rotate-45"
            :class="arrowClasses"
          ></div>

          <!-- Tooltip content -->
          <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 max-w-sm">
            <!-- Header -->
            <div class="p-6 pb-4">
              <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100" v-html="currentStep.title"></h3>
                <button
                  @click="skipTour"
                  class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                  title="Skip tour"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              
              <p class="text-gray-600 dark:text-gray-300 leading-relaxed" v-html="currentStep.description"></p>
              
              <!-- Action hint -->
              <div v-if="currentStep.action" class="mt-3 text-sm text-blue-600 dark:text-blue-400 font-medium">
                <span v-if="currentStep.action === 'type'" class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Try typing here
                </span>
                <span v-else-if="currentStep.action === 'click'" class="flex items-center">
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                  </svg>
                  Click to continue
                </span>
              </div>
            </div>

            <!-- Progress bar -->
            <div class="px-6 pb-2">
              <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">
                <span>Step {{ currentStepIndex + 1 }} of {{ steps.length }}</span>
                <span>{{ Math.round(progress) }}%</span>
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                <div 
                  class="bg-blue-500 h-1.5 rounded-full transition-all duration-300 ease-out"
                  :style="{ width: `${progress}%` }"
                ></div>
              </div>
            </div>

            <!-- Footer actions -->
            <div class="p-6 pt-4 border-t border-gray-100 dark:border-gray-700">
              <div class="flex items-center justify-between">
                <button
                  v-if="!isFirstStep"
                  @click="previousStep"
                  class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors"
                >
                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                  Previous
                </button>
                <div v-else></div>

                <div class="flex items-center space-x-3">
                  <button
                    @click="skipTour"
                    class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 transition-colors"
                  >
                    Skip Tour
                  </button>
                  <button
                    @click="nextStep"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm"
                  >
                    {{ isLastStep ? 'Finish' : 'Next' }}
                    <svg v-if="!isLastStep" class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <svg v-else class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, nextTick, watch, onMounted, onUnmounted } from 'vue'
import type { OnboardingStep } from '../composables/useOnboarding'

interface Props {
  isActive: boolean
  currentStep: OnboardingStep | null
  currentStepIndex: number
  steps: OnboardingStep[]
  progress: number
  isFirstStep: boolean
  isLastStep: boolean
}

interface Emits {
  nextStep: []
  previousStep: []
  skipTour: []
}

const props = defineProps<Props>()
const emit = defineEmits<Emits>()

const tooltipRef = ref<HTMLElement>()
const spotlightStyle = ref<Record<string, string>>({})
const tooltipStyle = ref<Record<string, string>>({})
const arrowStyle = ref<Record<string, string>>({})

const tooltipClasses = computed(() => {
  if (!props.currentStep) return ''
  
  const placement = props.currentStep.placement
  return {
    'tooltip-top': placement === 'top',
    'tooltip-bottom': placement === 'bottom',
    'tooltip-left': placement === 'left',
    'tooltip-right': placement === 'right'
  }
})

const arrowClasses = computed(() => {
  if (!props.currentStep) return ''
  
  const placement = props.currentStep.placement
  return {
    'arrow-top': placement === 'top',
    'arrow-bottom': placement === 'bottom',
    'arrow-left': placement === 'left',
    'arrow-right': placement === 'right'
  }
})

const nextStep = () => emit('nextStep')
const previousStep = () => emit('previousStep')
const skipTour = () => emit('skipTour')

const updatePositions = async () => {
  if (!props.currentStep || !props.isActive) return

  await nextTick()

  const targetElement = document.querySelector(props.currentStep.target) as HTMLElement
  if (!targetElement) return

  const targetRect = targetElement.getBoundingClientRect()
  const padding = props.currentStep.highlightPadding || 8
  const tooltipWidth = 380 // Approximate tooltip width
  const tooltipHeight = 200 // Approximate tooltip height

  // Calculate spotlight position (highlight area)
  spotlightStyle.value = {
    left: `${targetRect.left - padding}px`,
    top: `${targetRect.top - padding}px`,
    width: `${targetRect.width + padding * 2}px`,
    height: `${targetRect.height + padding * 2}px`
  }

  // Calculate tooltip position based on placement
  let tooltipLeft = 0
  let tooltipTop = 0
  let arrowLeft = 0
  let arrowTop = 0

  const placement = props.currentStep.placement
  const arrowSize = 12

  switch (placement) {
    case 'top':
      tooltipLeft = targetRect.left + targetRect.width / 2 - tooltipWidth / 2
      tooltipTop = targetRect.top - tooltipHeight - arrowSize - 10
      arrowLeft = tooltipWidth / 2 - arrowSize / 2
      arrowTop = tooltipHeight - 1
      break
    case 'bottom':
      tooltipLeft = targetRect.left + targetRect.width / 2 - tooltipWidth / 2
      tooltipTop = targetRect.bottom + arrowSize + 10
      arrowLeft = tooltipWidth / 2 - arrowSize / 2
      arrowTop = -arrowSize / 2 - 1
      break
    case 'left':
      tooltipLeft = targetRect.left - tooltipWidth - arrowSize - 10
      tooltipTop = targetRect.top + targetRect.height / 2 - tooltipHeight / 2
      arrowLeft = tooltipWidth - 1
      arrowTop = tooltipHeight / 2 - arrowSize / 2
      break
    case 'right':
      tooltipLeft = targetRect.right + arrowSize + 10
      tooltipTop = targetRect.top + targetRect.height / 2 - tooltipHeight / 2
      arrowLeft = -arrowSize / 2 - 1
      arrowTop = tooltipHeight / 2 - arrowSize / 2
      break
  }

  // Ensure tooltip stays within viewport
  const viewportWidth = window.innerWidth
  const viewportHeight = window.innerHeight

  if (tooltipLeft < 10) tooltipLeft = 10
  if (tooltipLeft + tooltipWidth > viewportWidth - 10) tooltipLeft = viewportWidth - tooltipWidth - 10
  if (tooltipTop < 10) tooltipTop = 10
  if (tooltipTop + tooltipHeight > viewportHeight - 10) tooltipTop = viewportHeight - tooltipHeight - 10

  tooltipStyle.value = {
    left: `${tooltipLeft}px`,
    top: `${tooltipTop}px`
  }

  arrowStyle.value = {
    left: `${arrowLeft}px`,
    top: `${arrowTop}px`
  }
}

// Watch for step changes and update positions
watch([() => props.currentStep, () => props.isActive], updatePositions, { immediate: true })

// Handle window resize
const handleResize = () => updatePositions()

onMounted(() => {
  window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
})
</script>

<style scoped>
/* Transition animations */
.onboarding-overlay-enter-active,
.onboarding-overlay-leave-active {
  transition: opacity 0.3s ease;
}

.onboarding-overlay-enter-from,
.onboarding-overlay-leave-to {
  opacity: 0;
}

/* Arrow positioning classes */
.arrow-top {
  border-top: none;
  border-left: none;
}

.arrow-bottom {
  border-bottom: none;
  border-right: none;
}

.arrow-left {
  border-left: none;
  border-bottom: none;
}

.arrow-right {
  border-right: none;
  border-top: none;
}

/* Custom animations for tooltip appearance */
@keyframes tooltip-bounce-in {
  0% {
    opacity: 0;
    transform: scale(0.9) translateY(10px);
  }
  50% {
    opacity: 1;
    transform: scale(1.02) translateY(-2px);
  }
  100% {
    opacity: 1;
    transform: scale(1) translateY(0);
  }
}

.tooltip-top,
.tooltip-bottom,
.tooltip-left,
.tooltip-right {
  animation: tooltip-bounce-in 0.4s ease-out;
}

/* Pulse animation for highlighted elements */
@keyframes pulse-highlight {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
  }
  50% {
    box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.1);
  }
}
</style>