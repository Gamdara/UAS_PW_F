<template>
    <div>
        <v-app-bar
        color="deep-purple"
        dark
        >
        <!-- <v-toolbar-title>Title</v-toolbar-title> -->
        <v-spacer></v-spacer>
        <v-icon @click="drawer = true">mdi-cart</v-icon>
        <v-icon @click="logout">mdi-logout</v-icon>
        </v-app-bar>

        <v-navigation-drawer
        v-model="drawer"
        absolute
        temporary
        right
        >
        <!-- nnti jadi shopping cart -->
        <v-list
            nav
            dense
        >
            <!-- <v-list-item-group
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
            </v-list-item-group> -->
        </v-list>
        </v-navigation-drawer>
        <v-main>
            <v-container>
                <router-view></router-view>
            </v-container>
        </v-main>
    </div>
</template>

<script>
/* eslint-disable */
import client from '@/api/request'

export default {
    name: 'UserLayout',
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