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
        <b-navbar class="nav-em">
            <v-icon>mdi-email</v-icon><p class="pt-4 ps-1">armedia.officiall@armedia.com</p>
        </b-navbar>
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

        <v-navigation-drawer v-model="drawer" fixed temporary right>
            <!-- nnti jadi shopping cart -->
            <v-list nav dense class="pa-2">
                <v-header class="">Keranjang</v-header>
                <v-card class="text-center" v-if="cart.length < 1">
                    <v-card-title>Keranjang kosong</v-card-title>
                </v-card>
                <template v-for="(item, i) in cart" >
                <v-divider
                    v-if=" i > 0"
                    :key="i"
                ></v-divider>

                <v-list-item :key="i">
                    <v-list-item-avatar>
                    <v-img :src="item.buku.cover"></v-img>
                    </v-list-item-avatar>

                    <v-list-item-content>
                    <v-list-item-subtitle v-html="item.buku.judul"></v-list-item-subtitle>
                    <v-list-item-title v-html="item.buku.harga * item.jumlah"></v-list-item-title>
                    <v-list-item-title>
                        <v-text-field
                            type="number"
                            prepend-icon="mdi-minus"
                            append-outer-icon="mdi-plus"
                            :value="item.jumlah"
                            @input="
                            item.jumlah = $event
                            editChart(item)
                            "
                            @click:prepend="
                            item.jumlah--;
                            editChart(item)
                            "
                            @click:append-outer="
                            item.jumlah++;
                            editChart(item)
                            "
                        ></v-text-field>
                    </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                </template>
            </v-list>
            <template v-slot:append v-if="cart.length > 0">
                <div class="pa-2">
                <v-btn block @click="dialog = true">
                    Checkout
                </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main>
            <v-container style="max-width: 100%; padding: 0;">
                <router-view></router-view>
            </v-container>
        </v-main>
        <Footer />

        <v-dialog v-model="dialog" max-width="600px">
            <v-card class="p-4">
              <v-card-title>Checkout</v-card-title>
              <v-card-sub-title>
                <v-list nav dense class="pa-2">
                    <template v-for="(item, i) in cart" >
                    <v-list-item :key="i">
                        <v-list-item-avatar>
                        <v-img :src="item.buku.cover"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>
                        <v-list-item-subtitle v-html="item.buku.judul"></v-list-item-subtitle>
                        <v-list-item-title v-html="item.buku.harga * item.jumlah"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    </template>
                </v-list>
              </v-card-sub-title>
              <v-card-title class="text-center">Total : {{ cart.reduce((total,x) => total + (x.jumlah * x.buku.harga),0) }}</v-card-title>
              <v-card-action>
                <v-btn color="success darken-1" text @click="
                  dialog = false
                  addTransaksi()
                  ">Iya</v-btn>
                <v-btn color="red darken-1" text @click="dialog = false">Tidak</v-btn>
              </v-card-action>
            </v-card>
        </v-dialog>
    </div>
</template>

<script setup>
/* eslint-disable */
import Footer from '@/components/FooterContent.vue'
import { useKeranjangStore } from '@/stores/keranjang';
import { useTransaksiStore } from '@/stores/transaksi';
import { useUserStore } from '@/stores/user';
import { computed, onMounted, ref } from 'vue';

const store = useUserStore()
const cartStore = useKeranjangStore()
const tranStore = useTransaksiStore()

const dialog = ref(false)
const errors = ref({})
const drawer = ref(false)

const user = computed(() => store.user);
const auth = computed(() => store.token);
const cart = computed(() => cartStore.keranjang);

async function logout(){
    const res = await store.logout()
    await cartStore.get()
    await tranStore.get()
}

async function editChart (data) {
    if(data.jumlah > 0) await cartStore.save(data) 
    else await cartStore.delete(data.buku_id) 
    await cartStore.get()
}

async function addTransaksi () {
    // console.log("trawdawda",{
    //     details : cartStore.keranjang.map(x => {return {...x, subtotal : x.buku.harga * x.jumlah} }),
    //     total : cartStore.keranjang.reduce((total,x) => total + (x.jumlah * x.buku.harga),0)
    // });
    await tranStore.insert({
        details : cartStore.keranjang.map(x => {return {...x, subtotal : x.buku.harga * x.jumlah} }),
        total : cartStore.keranjang.reduce((total,x) => total + (x.jumlah * x.buku.harga),0)
    }) 
    await cartStore.clear()
    await cartStore.get()
}

onMounted(async () => {
    await cartStore.get()
})

</script>

<style>
.nav-em{
    height: 25px;
    background-color: cornflowerblue;
    font-size: small;
    justify-content: end !important;
    padding: 15px 120px !important;
    position: sticky !important;
    left: 0 !important;
    right: 0 !important;
    top: 0 !important;
    z-index: 5;
}
.navbar-dekor {
    background-color: rgb(245, 245, 245);
    padding-left: 100px !important;
    padding-right: 100px !important;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
    position: sticky !important;
    left: 0 !important;
    right: 0 !important;
    top: 30px !important;
    z-index: 5;
}

@media screen and (max-width: 1316px) {
    .nav-em{
        padding: 15px 60px !important;
    }
    .navbar-dekor {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
}
</style>