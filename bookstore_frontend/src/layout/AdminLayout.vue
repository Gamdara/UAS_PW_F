<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
        >
            <v-list
            nav
            dense
            >
            <v-list-item-group
                v-model="group"
                active-class="deep-purple--text text--accent-4"
            >
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Home</v-list-item-title>
                </v-list-item>
                <v-list-item>
                <v-list-item-icon>
                    <v-icon>mdi-account</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Account</v-list-item-title>
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
            <v-toolbar-title>Title</v-toolbar-title>
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

<script>
/* eslint-disable */
// import client from '@/api/request'
export default {
    name: 'AdminLayout',
    data: () => ({
      drawer: false,
    }),
    methods: {
        logout(){
            localStorage.removeItem('token')
            this.$router.push('/login')
        }
    }
}
</script>

<style>

</style>