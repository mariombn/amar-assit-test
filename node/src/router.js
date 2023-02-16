import { createRouter, createWebHistory } from 'vue-router'
import ChargePage from './pages/ChargePage.vue'
import CustomerPage from './pages/CustomerPage.vue'

const routes = [
    {
        path: '/clientes',
        name: 'CustomerPage',
        component: CustomerPage
    },
    {
        path: '/cobrancas',
        name: 'ChargePage',
        component: ChargePage
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router