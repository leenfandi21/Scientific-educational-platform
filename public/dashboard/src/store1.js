import { createStore } from 'vuex'
import orders from './order'

const store = createStore({
  modules: {
    orders,
  },
})

export default store
