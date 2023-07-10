import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import PrimeVue from 'primevue/config'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import ToastService from 'primevue/toastservice'

import App from './App.vue'

const app = createApp(App)

app.use(createPinia())
app.use(PrimeVue)
app.use(ToastService)

app.component('Button', Button)
app.component('Dialog', Dialog)
app.component('InputText', InputText)

app.mount('#app')
