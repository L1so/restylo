import { ref, computed, onMounted } from 'vue'

// Onboarding step definition
export interface OnboardingStep {
  id: string
  title: string
  description: string
  target: string // CSS selector for the element to highlight
  placement: 'top' | 'bottom' | 'left' | 'right'
  action?: 'click' | 'type' | 'wait' // Optional action hint
  highlightPadding?: number // Padding around highlighted element
}

// Default onboarding steps for the Landing page
const defaultSteps: OnboardingStep[] = [
  {
    id: 'welcome',
    title: '👋 Welcome to ReStylo!',
    description: 'Let me show you how to get personalized outfit recommendations based on weather conditions.',
    target: '.onboarding-welcome-target',
    placement: 'bottom'
  },
  {
    id: 'event-input',
    title: '✨ Enter Your Event',
    description: 'Tell us what type of event you\'re dressing for. Try "casual", "formal", "date night", or anything else!',
    target: '.onboarding-event-input',
    placement: 'bottom',
    action: 'type',
    highlightPadding: 8
  },
  {
    id: 'location-input',
    title: '📍 Optional: Custom Location',
    description: 'We automatically detect your location, but you can specify a different city if needed.',
    target: '.onboarding-location-input',
    placement: 'bottom',
    highlightPadding: 8
  },
  {
    id: 'submit-button',
    title: '🚀 Get Your Outfit!',
    description: 'Click here to get AI-powered outfit recommendations based on current weather conditions.',
    target: '.onboarding-submit-button',
    placement: 'top',
    action: 'click',
    highlightPadding: 12
  },
  {
    id: 'results',
    title: '🎉 Your Perfect Outfit!',
    description: 'Here\'s your personalized outfit recommendation! You can expand details or try another event type.',
    target: '.onboarding-results-target',
    placement: 'top'
  }
]

const STORAGE_KEY = 'restylo_onboarding_completed'

export function useOnboarding() {
  const isActive = ref(false)
  const currentStepIndex = ref(0)
  const steps = ref<OnboardingStep[]>(defaultSteps)
  const isCompleted = ref(false)

  // Computed properties
  const currentStep = computed(() => {
    return steps.value[currentStepIndex.value] || null
  })

  const progress = computed(() => {
    if (steps.value.length === 0) return 0
    return ((currentStepIndex.value + 1) / steps.value.length) * 100
  })

  const isFirstStep = computed(() => currentStepIndex.value === 0)
  const isLastStep = computed(() => currentStepIndex.value === steps.value.length - 1)

  // Core methods
  const startTour = () => {
    isActive.value = true
    currentStepIndex.value = 0
    isCompleted.value = false
  }

  const nextStep = () => {
    if (currentStepIndex.value < steps.value.length - 1) {
      currentStepIndex.value++
    } else {
      completeTour()
    }
  }

  const previousStep = () => {
    if (currentStepIndex.value > 0) {
      currentStepIndex.value--
    }
  }

  const goToStep = (stepIndex: number) => {
    if (stepIndex >= 0 && stepIndex < steps.value.length) {
      currentStepIndex.value = stepIndex
    }
  }

  const skipTour = () => {
    completeTour()
  }

  const completeTour = () => {
    isActive.value = false
    isCompleted.value = true
    localStorage.setItem(STORAGE_KEY, 'true')
  }

  const resetTour = () => {
    localStorage.removeItem(STORAGE_KEY)
    isCompleted.value = false
    currentStepIndex.value = 0
  }

  // Check if user has completed onboarding before
  const checkOnboardingStatus = () => {
    const completed = localStorage.getItem(STORAGE_KEY)
    isCompleted.value = completed === 'true'
    return !isCompleted.value
  }

  // Start onboarding if it's a first-time user
  const initializeOnboarding = () => {
    const isFirstTime = checkOnboardingStatus()
    if (isFirstTime) {
      // Add a small delay to ensure the page is fully loaded
      setTimeout(() => {
        startTour()
      }, 1000)
    }
  }

  // Find target element for current step
  const getCurrentStepElement = (): HTMLElement | null => {
    if (!currentStep.value) return null
    return document.querySelector(currentStep.value.target) as HTMLElement
  }

  // Scroll to current step element
  const scrollToCurrentStep = () => {
    const element = getCurrentStepElement()
    if (element) {
      element.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'center' 
      })
    }
  }

  // Wait for specific step completion (e.g., form submission)
  const waitForStepCompletion = (stepId: string): Promise<void> => {
    return new Promise((resolve) => {
      if (currentStep.value?.id === stepId) {
        const checkCompletion = () => {
          // This will be resolved externally when the action is completed
          resolve()
        }
        // Store the resolver for external access
        ;(window as any).__onboardingResolver = checkCompletion
      } else {
        resolve()
      }
    })
  }

  // Trigger step completion externally
  const completeCurrentStep = () => {
    if ((window as any).__onboardingResolver) {
      ;(window as any).__onboardingResolver()
      delete (window as any).__onboardingResolver
    }
    nextStep()
  }

  // Custom step management
  const setSteps = (newSteps: OnboardingStep[]) => {
    steps.value = newSteps
  }

  const addStep = (step: OnboardingStep, index?: number) => {
    if (index !== undefined) {
      steps.value.splice(index, 0, step)
    } else {
      steps.value.push(step)
    }
  }

  // Initialize on mount
  onMounted(() => {
    initializeOnboarding()
  })

  return {
    // State
    isActive,
    currentStepIndex,
    steps,
    isCompleted,
    
    // Computed
    currentStep,
    progress,
    isFirstStep,
    isLastStep,
    
    // Methods
    startTour,
    nextStep,
    previousStep,
    goToStep,
    skipTour,
    completeTour,
    resetTour,
    checkOnboardingStatus,
    initializeOnboarding,
    getCurrentStepElement,
    scrollToCurrentStep,
    waitForStepCompletion,
    completeCurrentStep,
    setSteps,
    addStep
  }
}