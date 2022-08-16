<template>
  <div id="wrap">
    <Header />
    <router-view/>
    <Footer />
  </div>
</template>

<script>
import Header from './layout/Header';
import Footer from './layout/Footer';

export default{
  components: { Header, Footer },
  computed: {

  }
}
</script>

<style>
@font-face {
    font-family: 'GmarketSansMedium';
    src: url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_2001@1.1/GmarketSansMedium.woff') format('woff');
    font-weight: normal;
    font-style: normal;
}
* { 
  box-sizing: border-box; 
  text-decoration: none;
  list-style: none;
}
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  overflow-x: hidden;
}
body::-webkit-scrollbar { width: 15px;  /* 스크롤바의 너비 */ }
body::-webkit-scrollbar-thumb { background: #2B3F6B; /* 스크롤바의 색상 */ border-radius: 100px; }
body::-webkit-scrollbar-track { background: #f26d383c;  /*스크롤바 뒷 배경 색상*/ border-radius: 100px; }
#app {
  font-family: 'GmarketSansMedium';
  /* font-family: Avenir, Helvetica, Arial, sans-serif; */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  height: 100%;
}
#wrap {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
nav {
  padding: 30px;
}
nav a{
  color: white;
  text-decoration: none;
}
nav a.router-link-exact-active {
  color: white;
  text-decoration: none;
  pointer-events: none; 
}
.pointer {
  cursor: pointer;
}
.btn{
  margin-right:10px;
  border-radius:15px !important;
}
.mypage_nav{
  display :flex;
  justify-content : center;
}
.mypage_nav button{
  border:2px solid #2B3F6B;
  border-radius:15px;
  color:#2B3F6B;
}
.mypage_nav button:focus{
  outline:none;
  box-shadow:none;
}
</style>
