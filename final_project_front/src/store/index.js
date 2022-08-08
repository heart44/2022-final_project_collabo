import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';

export default createStore({
  state() {
    return {
      user: {},
      searchList: [],
      searchWord: '',
      currentLoc: {},
      restInfo: {},
    }
  },
  getters: {
    getSearchList(state) {
      return state.searchList;
    },
    getSearchWord(state) {
      return state.searchWord;
    },
    getCurrentLoc(state) {
      return state.currentLoc;
    },
  },
  mutations: {
    user: (state, data) => {
      state.user = data;
    },
    setSearchList: (state, data) => {
      state.searchList = data
    },
    setSearchWord: (state, data) => {
      state.searchWord = data
    },
    currentLoc: (state, data) => {
      state.currentLoc = data
    },
    restInfo: (state, data) => {
      state.restInfo = data
    }

  },
  plugins: [
    createPersistedState({
      paths: ['user'],
    })
  ],
})
