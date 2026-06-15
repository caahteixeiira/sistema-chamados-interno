<script setup>
import { watch } from 'vue'
const props = defineProps({
  form: Object,
  responsibles: Array,
  priorities: Array,
  statuses: Array,
  submitLabel: {
    type: String,
    default: 'Salvar',
  },
  showStatus: {
    type: Boolean,
    default: true,
},
})

const emit = defineEmits(['submit'])
watch(
  () => props.form.assign_automatically,
  (newValue) => {
    if (newValue === true) {
      props.form.responsible_id = ''
    }
  }
)
</script>

<template>
  <form @submit.prevent="emit('submit')" class="space-y-6">
    <div>
      <label class="block text-sm font-medium text-gray-700">Título</label>
      <input v-model="form.title" type="text" class="mt-1 w-full rounded-md border-gray-300" />
      <p v-if="form.errors.title" class="mt-1 text-sm text-red-600">{{ form.errors.title }}</p>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Descrição</label>
      <textarea v-model="form.description" rows="4" class="mt-1 w-full rounded-md border-gray-300"></textarea>
      <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">{{ form.errors.description }}</p>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Prioridade</label>
      <select v-model="form.priority" class="mt-1 w-full rounded-md border-gray-300">
        <option value="">Selecione</option>
        <option v-for="priority in priorities" :key="priority.value" :value="priority.value">
          {{ priority.label }}
        </option>
      </select>
      <p v-if="form.errors.priority" class="mt-1 text-sm text-red-600">{{ form.errors.priority }}</p>
    </div>


    <div>
  <label class="block text-sm font-medium text-gray-700">Responsável</label>
  <select
    v-model="form.responsible_id"
    :disabled="form.assign_automatically"
    class="mt-1 w-full rounded-md border-gray-300 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed"
  >
    <option value="">Selecione</option>
    <option v-for="responsible in responsibles" :key="responsible.id" :value="responsible.id">
      {{ responsible.name }}
    </option>
  </select>
  <p v-if="form.errors.responsible_id" class="mt-1 text-sm text-red-600">{{ form.errors.responsible_id }}</p>
</div>

    <div v-if="showStatus">
     <label class="block text-sm font-medium text-gray-700">Status</label>
    <select v-model="form.status" class="mt-1 w-full rounded-md border-gray-300">
     <option value="">Selecione</option>
      <option v-for="status in statuses" :key="status.value" :value="status.value">
      {{ status.label }}
      </option>
    </select>

  <p v-if="form.errors.status" class="mt-1 text-sm text-red-600">{{ form.errors.status }}</p>
  </div>

    <label class="flex items-center gap-2">
      <input v-model="form.assign_automatically" type="checkbox" class="rounded border-gray-300" />
      <span class="text-sm text-gray-700">Atribuir automaticamente ao responsável com menos chamados em aberto</span>
    </label>

    <button
      type="submit"
      :disabled="form.processing"
      class="rounded-md bg-gray-900 px-4 py-2 text-white disabled:opacity-50"
    >
      {{ form.processing ? 'Salvando...' : submitLabel }}
    </button>
    
  </form>
</template>