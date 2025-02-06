// orders.js
import axios from "axios"

const state = {
  orders: [],
}

const mutations = {
  setOrders(state, orders) {
    state.orders = orders
  },
}

const actions = {
  async fetchOrders({ commit }) {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/orders')

      commit('setOrders', response.data)
    } catch (error) {
      console.error(error)
    }
  },
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
}

