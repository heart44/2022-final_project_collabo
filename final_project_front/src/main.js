import { createApp } from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import mixins from './mixins';
import VueSweetalert2 from 'vue-sweetalert2';
import socketPlugin from "./plugins/socketPlugin";


import 'sweetalert2/dist/sweetalert2.min.css';


createApp(App).use(store).use(store)
.mixin(mixins)
.use(router)
.use(store)
.use(VueSweetalert2)
.use(socketPlugin)
.mount('#app');


window.Kakao.init('0e237d2f866c8e83e1f815fa788ed597')