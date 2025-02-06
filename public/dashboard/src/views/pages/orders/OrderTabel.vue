<template>
  <VTable>
    <thead>
      <tr>
        <th
          v-for="(header, index) in tableHeaders"
          :key="index"
        >
          {{ header }}
        </th>
      </tr>
    </thead>

    <tbody>
      <tr
        v-for="order in orders"
        :key="order.id"
      >
        <td
          v-for="(header, index) in tableHeaders"
          :key="index"
        >
          {{ order[header] }}
        </td>
      </tr>
    </tbody>
  </VTable>
</template>

<script setup>
import { useStore } from 'vuex'
import { computed, onMounted } from 'vue'

const store = useStore()

// Fetch orders from the server when the component is mounted
onMounted(async () => {
  await store.dispatch('orders/fetchOrders')
})

// Get the orders from the store
const orders = computed(() => store.state.orders.orders)

// Get the table headers from the first order object
const tableHeaders = computed(() => {
  if (orders.value.length > 0) {
    return Object.keys(orders.value[0])
  }
  
  return []
})
</script>
