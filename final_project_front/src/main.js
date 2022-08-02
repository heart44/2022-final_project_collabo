import { createApp } from 'vue'
import App from './App.vue'
import mixins from './mixins'
import router from './router'
import store from './store'

createApp(App).use(store).use(router).mixin(mixins).mount('#app')

window.Kakao.init('0e237d2f866c8e83e1f815fa788ed597');
