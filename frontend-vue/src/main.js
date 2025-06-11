import { createApp } from 'vue';
import 'core-js/stable';
import App from './App.vue';
import router from './router';
import store from './store';

import 'bootstrap/dist/css/bootstrap.min.css';
import './assets/styles.css';

// createApp(App).mount('#app')

createApp(App)
  .use(router) // routes for navigation
  .use(store) // store for token
  .mount('#app');
