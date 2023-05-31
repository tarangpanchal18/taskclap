import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue'
import Welcome from './components/Welcome.vue'

window.Alpine = Alpine;

Alpine.start();

const app = createApp({})

app.component('welcome', Welcome)

app.mount('#app')
