<script setup>
import { computed, ref } from 'vue'

defineProps({
  align: {
    type: String,
    default: 'left',
  },
  width: {
    type: String,
    default: '48',
  },
  contentClasses: {
    type: Array,
    default: () => ['py-1', 'bg-white'],
  },
})

const open = ref(false)

const alignmentClasses = computed(() => {
  return {
    left: 'origin-top-left left-0',
    right: 'origin-top-right right-0',
  }[align]
})

const widthClasses = computed(() => {
  return {
    48: 'w-48',
  }[width]
})

const toggle = () => {
  open.value = !open.value
}

const close = () => {
  open.value = false
}
</script>

<template>
  <div class="relative inline-block text-left">
    <div @click="toggle">
      <slot name="trigger" />
    </div>

    <!-- Background -->
    <div
      v-show="open"
      class="fixed inset-0 z-40"
      @click="close"
    />

    <!-- Dropdown Content -->
    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div
        v-show="open"
        :class="[`absolute z-50 mt-2 rounded-md shadow-lg ${alignmentClasses} ${widthClasses}`, contentClasses]"
      >
        <slot name="content" />
      </div>
    </transition>
  </div>
</template>
