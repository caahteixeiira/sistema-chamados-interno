<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import TicketStatusBadge from '@/Components/Tickets/TicketStatusBadge.vue'
import TicketPriorityBadge from '@/Components/Tickets/TicketPriorityBadge.vue'

defineOptions({
  layout: AuthenticatedLayout,
})

defineProps({
  ticket: Object,
})
</script>

<template>
  <div class="mx-auto max-w-4xl p-6">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-2xl font-bold">
        {{ ticket.title }}
      </h1>
      <Link
        :href="route('tickets.edit', ticket.id)"
        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white"
      >
        Editar
      </Link>
    </div>

    <div class="grid gap-6 rounded-lg border bg-white p-6">
      <!-- Status e Prioridade -->
      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="text-sm font-semibold text-gray-700">Status</label>
          <div class="mt-2">
            <TicketStatusBadge :status="ticket.status" />
          </div>
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Prioridade</label>
          <div class="mt-2">
            <TicketPriorityBadge :priority="ticket.priority" />
          </div>
        </div>
      </div>

      <!-- Responsável -->
      <div>
        <label class="text-sm font-semibold text-gray-700">Responsável pelo Atendimento</label>
        <p class="mt-2 text-gray-900">
          {{ ticket.responsible?.name ?? 'Não atribuído' }}
        </p>
      </div>

      <!-- Data de Abertura -->
      <div>
        <label class="text-sm font-semibold text-gray-700">Data e Hora de Abertura</label>
        <p class="mt-2 text-gray-900">
          {{ ticket.opened_at }}
        </p>
      </div>

      <!-- Descrição -->
      <div>
        <label class="text-sm font-semibold text-gray-700">Descrição</label>
        <div class="mt-2 whitespace-pre-wrap rounded-md border border-gray-200 bg-gray-50 p-4 text-gray-900">
          {{ ticket.description }}
        </div>
      </div>

      <!-- Datas de Criação/Atualização -->
      <div class="grid gap-4 border-t pt-4 md:grid-cols-2 text-sm text-gray-600">
        <div>
          <span class="font-semibold">Criado em:</span> {{ ticket.created_at }}
        </div>
        <div>
          <span class="font-semibold">Atualizado em:</span> {{ ticket.updated_at }}
        </div>
      </div>

      <!-- Ações -->
      <div class="flex gap-3 border-t pt-6">
        <Link
          :href="route('tickets.edit', ticket.id)"
          class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
        >
          Editar
        </Link>
        <Link
          :href="route('tickets.index')"
          class="rounded-md bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700"
        >
          Voltar à Lista
        </Link>
      </div>
    </div>
  </div>
</template>