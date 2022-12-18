import auth from '@/middleware/auth'
// import logged from '@/middleware/logged'
import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UserLayout from '../layout/UserLayout.vue'
import AdminLayout from '../layout/AdminLayout.vue'
import HelloWorld from '../components/HelloWorld.vue'
import Genre from '../views/admin/Genres.vue'
import Penulis from '../views/admin/Penulis.vue'
import Buku from '../views/admin/Buku.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: UserLayout,
    // beforeEnter: auth,
    children: [
      {
        path: '/',
        name: 'Home',
        component: HomeView
      },
      {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "store" */ '../views/LoginView.vue')
        // beforeEnter: logged
      },
      {
        path: '/register',
        name: 'register',
        component: () => import(/* webpackChunkName: "store" */ '../views/RegisterView.vue')
        // beforeEnter: logged
      },
      {
        path: '/about',
        name: 'about',
        component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
      },
      {
        path: '/profile',
        name: 'profile',
        component: () => import(/* webpackChunkName: "profile" */ '../components/Profil.vue')
      },
      {
        path: '/detail',
        name: 'detail',
        component: () => import(/* webpackChunkName: "about" */ '../views/DetailBuku.vue')
      },
      {
        path: '/kategori',
        name: 'kategori',
        component: () => import(/* webpackChunkName: "about" */ '../views/KategoriView.vue')
      },
      {
        path: '/tampilList',
        name: 'tampilList',
        component: () => import(/* webpackChunkName: "about" */ '../views/TampilList.vue')
      }
    ]
  },
  {
    path: '/admin',
    component: AdminLayout,
    beforeEnter: auth,
    children: [
      {
        path: '/admin/home',
        name: 'AdminHome',
        component: HelloWorld,
        alias: '/'
      },
      {
        path: '/admin/genre',
        name: 'AdminGenre',
        component: Genre
      },
      {
        path: '/admin/penulis',
        name: 'AdminPenulis',
        component: Penulis
      },
      {
        path: '/admin/buku',
        name: 'AdminBuku',
        component: Buku
      }
    ]
  }
  // {
  //   path: '/login',
  //   name: 'login',
  //   component: () => import(/* webpackChunkName: "store" */ '../views/LoginView.vue'),
  //   beforeEnter: logged
  // },
  // {
  //   path: '/register',
  //   name: 'register',
  //   component: () => import(/* webpackChunkName: "store" */ '../views/RegisterView.vue'),
  //   beforeEnter: logged
  // }
  // {
  //   path: '/about',
  //   name: 'about',
  //   component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  // }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
