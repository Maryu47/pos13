import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import Menu from './components/MenuSidebar.vue';
import Pagination from './components/Pagination.vue';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { createPinia } from 'pinia';
const pinia = createPinia();

const app = createApp(App)
app.use(router)
app.use(pinia)
app.use(VueSweetalert2)
app.component('Pagination',Pagination)
app.component('MenuSideBar',Menu)
app.mount('#app-vue');
