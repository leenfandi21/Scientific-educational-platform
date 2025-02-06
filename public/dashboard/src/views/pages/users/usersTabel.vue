<template>
  <VTable fixed-header>
    <thead>
      <tr>
        <th
          v-for="label in columnLabels"
          :key="label"
          class="text-uppercase"
        >
          {{ label }}
        </th>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="user in users"
        :key="user.id"
      >
        <td
          v-for="label in columnLabels"
          :key="label"
        >
          {{ user[label] }}
        </td>
      </tr>
    </tbody>
  </VTable>
</template>

<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"

const users = ref([])
const columnLabels = ref([])

onMounted(async () => {
  try {
    const columnLabelsResponse = axios.get('http://127.0.0.1:8000/api/column-labels')
    const usersResponse = axios.get('http://127.0.0.1:8000/api/users')

    const [columnLabelsData, usersData] = await Promise.all([columnLabelsResponse, usersResponse])

    columnLabels.value = columnLabelsData.data.map(label => label.toLowerCase())
    users.value = usersData.data
  } catch (error) {
    console.error(error)
  }
})
</script>
