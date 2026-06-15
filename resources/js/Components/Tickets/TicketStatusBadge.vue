<script setup>
defineProps({
  status: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <span
    class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
    :class="{
      'bg-blue-100 text-blue-800': status === 'open',
      'bg-yellow-100 text-yellow-800': status === 'in_progress',
      'bg-green-100 text-green-800': status === 'resolved',
      'bg-gray-100 text-gray-800': status === 'closed',
    }"
  >
    {{
      {
        open: 'Aberto',
        in_progress: 'Em andamento',
        resolved: 'Resolvido',
        closed: 'Fechado',
      }[status]
    }}
  </span>
</template>