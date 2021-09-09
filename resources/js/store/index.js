import { createStore } from "vuex";

// Create a new store instance.
const store = createStore({
  state() {
    return {
      count: 0,
    };
  },
  mutations: {
    INCREMENT(state) {
      state.count++;
    },
  },
});

export default store;
