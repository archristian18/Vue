import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import SignUp from '../views/SignUp.vue'
import ForgotPassword from '../views/ForgotPassword.vue'
import UserActivation from '../views/UserActivation.vue'
import ResetPassword from '../views/ResetPassword.vue'
import MenuTable from '../views/MenuTable.vue'
import OrderTable from '../views/OrderTable.vue'
import ReceiptView from '../views/ReceiptView.vue'
import AddMenu from '../views/AddMenu.vue'

const routes = [
    {
        path: '/login',
        name: 'login',
        component: LoginView,
    },
    {
        path: '/signup',
        name: 'signup',
        component: SignUp,
    },
    {
        path: '/home',
        name: 'home',
        component: HomeView,
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: ForgotPassword,
    },
    {
        path: '/activate',
        name: 'UserActivation',
        component: UserActivation,
    },
    {
        path: '/password/reset',
        name: 'reset-password',
        component: ResetPassword,
    },
    {
        path: '/menu/table',
        name: 'menu-table',
        component: MenuTable,
    },
    {
        path: '/order/table',
        name: 'order-table',
        component: OrderTable,
    },
    {
        path: '/receipt',
        name: 'receipt',
        component: ReceiptView,
    },
    {
        path: '/menu/add',
        name: 'add-menu',
        component: AddMenu,
        props: (route) => ({
            isEditing: route.query.isEditing === 'true', // Convert the string to a boolean
            menuData: route.query.menuData || null, // Parse the JSON or set to null
        }),
    },
]

const router = createRouter({
    // history: createWebHistory(process.env.BASE_URL),
    history: createWebHistory('/'),
    routes,
})

export default router
