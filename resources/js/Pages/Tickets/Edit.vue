<script setup>
import { useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TicketForm from '@/Components/Tickets/TicketForm.vue'

defineOptions({
  layout: AuthenticatedLayout,
})

const props = defineProps({
  ticket: Object,
  responsibles: Array,
  priorities: Array,
  statuses: Array,
})

const form = useForm({
  title: props.ticket.title,
  description: props.ticket.description,
  priority: props.ticket.priority,
  status: props.ticket.status,
  responsible_id: props.ticket.responsible_id,
  assign_automatically: false,
})

const submit = () => {
  form.put(route('tickets.update', props.ticket.id))
}
</script>

<template>
  <div class="mx-auto max-w-4xl p-6">
    <h1 class="mb-6 text-2xl font-bold">
      Editar Chamado
    </h1>

    <TicketForm
      :form="form"
      :responsibles="responsibles"
      :priorities="priorities"
      :statuses="statuses"
      submit-label="Atualizar Chamado"
      @submit="submit"
    />
  </div>
</template>