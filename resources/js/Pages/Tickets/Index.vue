<script setup>
import { router, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import TicketStatusBadge from '@/Components/Tickets/TicketStatusBadge.vue'
import TicketPriorityBadge from '@/Components/Tickets/TicketPriorityBadge.vue'

defineOptions({
  layout: AppLayout,
})

const props = defineProps({
  tickets: Object,
  filters: Object,
  responsibles: Array,
  statuses: Array,
  priorities: Array,
})

const applyFilters = (event) => {
  const formData = new FormData(event.target)

  router.get(route('tickets.index'), {
    search: formData.get('search') || undefined,
    status: formData.get('status') || undefined,
    priority: formData.get('priority') || undefined,
    responsible_id: formData.get('responsible_id') || undefined,
  }, {
    preserveState: true,
    replace: true,
  })
}
const formatDate = (date) => {
  const formatted = new Date(date)

  return `${formatted.toLocaleDateString('pt-BR')} às ${formatted.toLocaleTimeString('pt-BR', {
    hour: '2-digit',
    minute: '2-digit',
  })}`
}
</script>

<template>
  <div class="mx-auto max-w-7xl p-6">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold">Chamados Internos</h1>
        <p class="text-sm text-gray-600">Acompanhe e gerencie os chamados da empresa.</p>
      </div>

      <Link
        :href="route('tickets.create')"
        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white"
      >
        Novo Chamado
      </Link>
    </div>

    <form @submit.prevent="applyFilters" class="mb-6 grid gap-4 rounded-lg border bg-white p-4 md:grid-cols-5">
      <input
        name="search"
        type="text"
        placeholder="Buscar por título"
        :default-value="filters.search"
        class="rounded-md border-gray-300"
      />

      <select name="status" :default-value="filters.status" class="rounded-md border-gray-300">
        <option value="">Todos os status</option>
        <option v-for="status in statuses" :key="status.value" :value="status.value">
          {{ status.label }}
        </option>
      </select>

      <select name="priority" :default-value="filters.priority" class="rounded-md border-gray-300">
        <option value="">Todas as prioridades</option>
        <option v-for="priority in priorities" :key="priority.value" :value="priority.value">
          {{ priority.label }}
        </option>
      </select>

      <select name="responsible_id" :default-value="filters.responsible_id" class="rounded-md border-gray-300">
        <option value="">Todos os responsáveis</option>
        <option v-for="responsible in responsibles" :key="responsible.id" :value="responsible.id">
          {{ responsible.name }}
        </option>
      </select>

      <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-white">
        Filtrar
      </button>
    </form>

    <div class="overflow-hidden rounded-lg border bg-white">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Título</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Prioridade</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Responsável</th>
            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Abertura</th>
            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Ações</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
          <tr v-for="ticket in tickets.data" :key="ticket.id">
            <td class="px-4 py-3 text-sm font-medium text-gray-900">
              {{ ticket.title }}
            </td>

            <td class="px-4 py-3">
              <TicketPriorityBadge :priority="ticket.priority" />
            </td>

            <td class="px-4 py-3">
              <TicketStatusBadge :status="ticket.status" />
            </td>

            <td class="px-4 py-3 text-sm text-gray-700">
              {{ ticket.responsible?.name ?? 'Não atribuído' }}
            </td>

            <td class="px-4 py-3 text-sm text-gray-700">
  {{ formatDate(ticket.opened_at) }}
</td>

            <td class="px-4 py-3 text-right text-sm">
              <Link :href="route('tickets.show', ticket.id)" class="text-gray-700 hover:underline">
                Ver
              </Link>

              <span class="mx-2 text-gray-300">|</span>

              <Link :href="route('tickets.edit', ticket.id)" class="text-gray-700 hover:underline">
                Editar
              </Link>
            </td>
          </tr>

          <tr v-if="tickets.data.length === 0">
            <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
              Nenhum chamado encontrado.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>