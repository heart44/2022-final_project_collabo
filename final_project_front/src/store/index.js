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
      year: [],
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
    updateUser: (state, data) => {
        for(const value in data) {
          state.user[value] = data[value];
        }
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
    bobfDetailInfo: (state, data) => {
      state.bobfDetailInfo = data
    },
    year: (state) => {
      state.year = [];
      for(let i = new Date().getFullYear(); i>1899; i--) {
        state.year.push(i);
      }
    }
  },
  plugins: [
    createPersistedState({
      paths: ['user'],
    })
  ],
})
