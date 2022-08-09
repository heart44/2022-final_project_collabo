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
      restList: [],
      bobfDetailInfo: {}
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
    getRestList(state) {
      return state.restList;
    }
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
    restList: (state, data) => {
      state.restList = data
    },
    // restInfo: (state, data) => {
    //   state.restInfo = data
    // },
    bobfDetailInfo: (state, data) => {
      state.bobfDetailInfo = data
    }

  },
  plugins: [
    createPersistedState({
      paths: ['user'],
    })
  ],
})
