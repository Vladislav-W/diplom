import Vue from 'vue'

import VueRouter from 'vue-router'

import NewRequestPage from '@/views/NewRequestPage.vue'   // страница создания новой заявки
import RequestsPage from '@/views/RequestsPage.vue'       // заявки на создание маршрута
import AllRequestsPage from '@/views/AllRequestsPage.vue' // все заявки что были и не были реализованы
import RouteFormPage from '@/views/RouteFormPage.vue'     // формирование маршрута из заявок

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