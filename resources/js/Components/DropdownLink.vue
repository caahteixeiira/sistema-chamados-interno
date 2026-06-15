<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  href: String,
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
    class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
  >
    <slot />
  </Link>
</template>
