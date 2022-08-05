import { createStore } from 'vuex'

export default createStore({
  state() {
    return {
      user: {},
      searchList: [],
      searchWord: '',
    }
  },
  getters: {
    getSearchList(state) {
      return state.searchList;
    },
    getSearchWord(state) {
      return state.searchWord;
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
    }
  },
})
