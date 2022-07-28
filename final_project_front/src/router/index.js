import { createRouter, createWebHistory } from 'vue-router';
import LoginJoin from '../views/LoginJoin';
import PassWord from '../views/PassWord';
import KakaoLogin from '../views/KakaoLogin';
import NaverLogin from '../views/NaverLogin';
import Main from '../views/Main'

const routes = [
  {
    path: '/',
    name: 'Main',
    component: Main
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

];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router;
