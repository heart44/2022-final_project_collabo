import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store';

import Main from '../views/Main';
import SearchList from '../views/SearchList'

import BobfList from '../views/BobfList'
import BobfDetail from '../views/BobfDetail'
import BobfWrite from '../views/BobfWrite'
import BobfChat from '../views/BobfChat'
import BobfChatView from '@/components/BobfChatView'

import LoginJoin from '../views/LoginJoin';
import PassWord from '../views/PassWord';
import ResetPassWord from '../views/ResetPassWord'

import Diary from '../views/Diary';
import Profile from '../views/Profile';
import DiaryWrite from '../views/DiaryWrite';


//네비게이션 가드
const requireAuth = () => (to, from, next) => {
  if(store.state.user.iuser === undefined){
    swal.fire('로그인을 하세요.', '', 'warning');
    return;
  }
  next();
}

const routes = [
  {
    path: '/',
    name: 'Main',
    component: Main
  },
  {
    path: '/SearchList',
    name: 'SearchList',
    component: SearchList
  },
  {
    path: '/BobfList',
    name: 'BobfList',
    component: BobfList
  },
  {
    path: '/BobfDetail/:ibobf',
    name: 'BobfDetail',
    component: BobfDetail
  },
  {
    path: '/BobfWrite',
    name: 'BobfWrite',
    component: BobfWrite
  },
  {
    path: '/BobfChat',
    name: 'BobfChat',
    component: BobfChat
  },
  {
    path: '/BobfChatView',
    name: 'BobfChatView',
    component: BobfChatView
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
    path: '/ResetPassWord',
    name: 'ResetPassWord',
    component: ResetPassWord,
    props: true
  },
  {
    path:'/Diary',
    name: 'Diary',
    component:Diary
  },
  {
    path:'/Profile',
    name:'Profile',
    component: Profile
  },
  {
    path:'/DiaryWrite',
    name:'DiaryWrite',
    component: DiaryWrite
  },
  
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router
