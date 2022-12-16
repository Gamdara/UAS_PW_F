<template>
    <div>
        <!-- <v-app-bar color="white" class="px-5">
            <v-toolbar-title>
                <img src="../assets/Armedia-logo.png" alt="logo" width="150px">
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-icon @click="drawer = true">mdi-cart</v-icon>
            <v-icon @click="logout">mdi-logout</v-icon>
        </v-app-bar> -->
        <b-navbar toggleable="lg" type="light" class="navbar-dekor">
            <b-navbar-brand router-link to="/">
                <img src="../assets/Armedia-logo.png" alt="logo" width="150px">
            </b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item router-link to="/">Home</b-nav-item>
                    <b-nav-item-dropdown right>
                        <template #button-content>
                            Tentang
                        </template>
                        <b-dropdown-item router-link to="/about">Tentang Armedia</b-dropdown-item>
                        <b-dropdown-item href="#">Lokasi</b-dropdown-item>
                        <b-dropdown-item href="#">Blog</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item-dropdown right>
                        <template #button-content>
                            Kategori
                        </template>
                        <b-dropdown-item href="#">Buku Fiksi</b-dropdown-item>
                        <b-dropdown-item href="#">Buku Non Fiksi</b-dropdown-item>
                        <b-dropdown-item href="#">Majalah</b-dropdown-item>
                        <b-dropdown-item href="#">Kamus</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item href="#">Terbaru</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto" style="z-index: 50;">
                    <!-- <b-nav-form>
                        <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                        <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                    </b-nav-form> -->
                    <b-nav-item @click="drawer = true" class="me-4"><v-icon>mdi-cart</v-icon></b-nav-item>
                    <span v-if="auth">
                        <b-nav-item-dropdown left>
                            <template #button-content>
                                <em>{{user.nama}}</em>
                            </template>
                            <b-dropdown-item to="/profile">Profile</b-dropdown-item>
                            <b-dropdown-item @click="logout">Sign Out</b-dropdown-item>
                        </b-nav-item-dropdown>
                    </span>
                    <span v-else>
                        <v-btn color="blue" dark outlined router-link to="/login"><v-icon>mdi-login-variant</v-icon> MASUK</v-btn>
                    </span>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>

        <v-navigation-drawer v-model="drawer" absolute temporary right>
            <!-- nnti jadi shopping cart -->
            <v-list nav dense>
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
            <v-container style="max-width: 100%; padding: 0;">
                <router-view></router-view>
            </v-container>
        </v-main>
        <Footer />
    </div>
</template>

<script setup>
/* eslint-disable */
import Footer from '@/components/FooterContent.vue'
import { useUserStore } from '@/stores/user';
import { computed, ref } from 'vue';

const store = useUserStore()

const errors = ref({})
const drawer = ref(false)

const user = computed(() => store.user);
const auth = computed(() => store.token);

async function logout(){
    const res = await store.logout()
}

</script>

<style>
.navbar-dekor {
    background-color: rgb(245, 245, 245);
    padding-left: 100px !important;
    padding-right: 100px !important;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    position: sticky !important;
    left: 0 !important;
    right: 0 !important;
    top: 0 !important;
    z-index: 5;
}

@media screen and (max-width: 1316px) {
    .navbar-dekor {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}
</style>