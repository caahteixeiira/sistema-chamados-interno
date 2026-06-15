<script setup>
defineProps({
  priority: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <span
    class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
    :class="{
      'bg-green-100 text-green-800': priority === 'low',
      'bg-yellow-100 text-yellow-800': priority === 'medium',
      'bg-red-100 text-red-800': priority === 'high',
    }"
  >
    {{
      {
        low: 'Baixa',
        medium: 'Média',
        high: 'Alta',
      }[priority]
    }}
  </span>
</template>