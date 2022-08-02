<template>
  <div id="wrap">
    <Header />
    <router-view />
    <Footer />
  </div>
</template>

<script>
import Header from './layout/Header';
import Footer from './layout/Footer';

export default{
  components: {Header, Footer},
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
html, body { height: 100%; margin: 0; }
#app {
  font-family: 'GmarketSansMedium';
  /* font-family: Avenir, Helvetica, Arial, sans-serif; */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
main {
  min-height: 100%;
}
main > div {  }
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
footer {
  height: 80px;
  /* position: relative;
  transform: translateY(-100%); */
}
</style>
