import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView'
import BobfWrite from '../views/BobfWrite'
import BobfList from '../views/BobfList'

import LoginJoin from '../views/LoginJoin';
import PassWord from '../views/PassWord';
import KakaoLogin from '../views/KakaoLogin';
import NaverLogin from '../views/NaverLogin';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/BobfList',
    name: 'BobfList',
    component: BobfList
  },
  {
    path: '/BobfWrite',
    name: 'BobfWrite',
    component: BobfWrite
  },
  {
    path: '/LoginJoin',
    name: 'LoginJoin',
    component: LoginJoin
  },
  {
    path: '/PassWord',
    name: 'PassWord',
    component: PassWord
  },
  {
    path: '/KakaoLogin',
    name: 'KakaoLogin',
    component: KakaoLogin
  },
  {
    path: '/NaverLogin',
    name:'NaverLogin',
    component:NaverLogin
  },
  {
    path:'/PassWord',
    name: 'PassWord',
    component: PassWord
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
