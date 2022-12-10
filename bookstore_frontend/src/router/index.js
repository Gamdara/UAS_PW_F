import auth from '@/middleware/auth'
import logged from '@/middleware/logged'
import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserLayout from '../layout/UserLayout.vue'
import AdminLayout from '../layout/AdminLayout.vue'
import HelloWorld from '../components/HelloWorld.vue'
import Genre from '../views/admin/Genres.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: UserLayout,
    beforeEnter: auth,
    children: [
      {
        path: '/',
        name: 'Home',
        component: HomeView
      }
    ]
  },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      {
        path: '/',
        name: 'AdminHome',
        component: HelloWorld
      },
      {
        path: '/admin/genre',
        name: 'AdminGenre',
        component: Genre
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "store" */ '../views/LoginView.vue'),
    beforeEnter: logged
  },
  {
    path: '/about',
    name: 'about',
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
