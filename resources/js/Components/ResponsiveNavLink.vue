<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: String,
  active: Boolean,
  method: {
    type: String,
    default: 'get',
  },
  as: {
    type: String,
    default: 'a',
  },
})
</script>

<template>
  <Link
    :href="href"
    :method="method"
    :as="as"
    :class="[
      'block w-full pl-3 pr-4 py-2 border-l-4 text-left text-base font-medium transition duration-150 ease-in-out',
      active
        ? 'border-gray-800 bg-gray-50 text-gray-800 focus:text-gray-800 focus:bg-gray-100 focus:border-gray-700'
        : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300',
    ]"
  >
    <slot />
  </Link>
</template>
