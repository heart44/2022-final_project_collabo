import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate';
import vue from 'vue';


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
      menuList: [],
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
    },
    getMenuList(state) {
      return state.menuList;
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
    year: (state) => {
      state.year = [];
      for(let i = new Date().getFullYear(); i>1899; i--) {
        state.year.push(i);
      }
    },
    setMenuList: (state, data) => {
      state.menuList = data
    }
  },
  plugins: [
    createPersistedState({
      paths: ['user.iuser', 'user.email', 'user.nick', 'user.profileimg', 'user.birth'],
      storage: window.sessionStorage,
    })
  ],
})