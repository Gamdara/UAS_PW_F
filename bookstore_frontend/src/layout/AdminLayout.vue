<template>
    <div>
        <v-navigation-drawer
            dark
            permanent
            app
            clipped
            :mini-variant.sync="drawer"
        >
            <v-list
            nav
            dense
            dark
            @hover="(drawer=true)"
            >
            <v-list-item-group
                dark
                active-class=""
            >
                <v-list-item v-for="link in links" :key="link.title" :to="link.link">
                    <v-list-item-icon>
                        <v-icon>{{link.icon}}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{link.title}}</v-list-item-title>
                </v-list-item>
                <v-spacer></v-spacer>
                <v-list-item @click="logout">
                    <v-list-item-icon>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list-item-group>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            color="deep-purple"
            dark
            clipped-left
            app
        >
            <v-app-bar-nav-icon @click="(drawer = !drawer)"></v-app-bar-nav-icon>
            <v-toolbar-title>Admin</v-toolbar-title>
        </v-app-bar>
        <v-main>
            <v-container fluid>
            <router-view></router-view>
            </v-container>
        </v-main>
        <v-footer app>
            <!-- -->
        </v-footer>
    </div>
  </template>

<script setup>
/* eslint-disable */
import { useKeranjangStore } from '@/stores/keranjang';
import { useTransaksiStore } from '@/stores/transaksi';
import { useUserStore } from '@/stores/user';

const store = useUserStore()
const cartStore = useKeranjangStore()
const tranStore = useTransaksiStore()

async function logout(){
    const res = await store.logout()
    await cartStore.get()
    await tranStore.get()
}

</script>

<script>
/* eslint-disable */

import client from '@/api/request';

// import client from '@/api/request'
export default {
    name: 'AdminLayout',
    data: () => ({
      drawer: false,
      links: [
        {
          icon: 'mdi-book',
          title: 'Genre',
          link: {name: 'AdminGenre'}
        },
        {
          icon: 'mdi-account',
          title: 'Penulis',
          link: {name: 'AdminPenulis'}
        },
        {
          icon: 'mdi-book',
          title: 'Buku',
          link: {name: 'AdminBuku'}
        }
      ]
    })
}
</script>

<style>

</style>