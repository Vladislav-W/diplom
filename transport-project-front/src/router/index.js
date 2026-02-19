import Vue from 'vue'
import VueRouter from 'vue-router'
import NewRequestPage from '@/views/NewRequestPage.vue'
import RequestsPage from '@/views/RequestsPage.vue'
import AllRequestsPage from '@/views/AllRequestsPage.vue'
import EditRequestPage from '@/views/EditRequestPage.vue'
import RouteFormPage from '@/views/RouteFormPage.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: '/new-request'
  },
  {
    path: '/new-request',
    name: 'NewRequest',
    component: NewRequestPage
  },
  {
    path: '/requests',
    name: 'Requests',
    component: RequestsPage
  },
  {
    path: '/all-requests',
    name: 'AllRequests',
    component: AllRequestsPage
  },
  {
    path: '/requests/request/:id',
    name: 'EditRequest',
    component: EditRequestPage
  },
  {
    path: '/route-form',
    name: 'RouteForm',
    component: RouteFormPage
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router