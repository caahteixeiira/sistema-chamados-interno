<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TicketForm from '@/Components/Tickets/TicketForm.vue'

defineOptions({
  layout: AuthenticatedLayout,
})

const props = defineProps({
  responsibles: Array,
  priorities: Array,
  statuses: Array,
})

const form = useForm({
  title: '',
  description: '',
  priority: '',
  status: 'open',
  responsible_id: '',
  assign_automatically: false,
})

const submit = () => {
  form.post(route('tickets.store'))
}
</script>

<template>
  <div class="mx-auto max-w-4xl p-6">
    <h1 class="mb-6 text-2xl font-bold">
      Novo Chamado
    </h1>

    <TicketForm
  :form="form"
  :responsibles="responsibles"
  :priorities="priorities"
  :statuses="statuses"
  :show-status="false"
  submit-label="Criar Chamado"
  @submit="submit"
/>
  </div>
</template>