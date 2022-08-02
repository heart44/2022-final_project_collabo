import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import mixins from './mixins';

createApp(App)
.mixin(mixins)
.use(router)
.use(store)
.mount('#app');

window.Kakao.init('0e237d2f866c8e83e1f815fa788ed597');
// window.Naver.init();
