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
                    <!-- <b-nav-item-dropdown right>
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
                    </b-nav-item-dropdown> -->
                    <b-nav-item to="/histori">Riwayat Pemebelian</b-nav-item>
                </b-navbar-nav>

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto" style="z-index: 50;">
                    <!-- <b-nav-form>
                        <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                        <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                    </b-nav-form> -->
                    <v-badge
                        :content="cart.length"
                        :value="cart.length"
                        color="green"
                        overlap
                    >
                        <b-nav-item @click="drawer = true" ><v-icon>mdi-cart</v-icon></b-nav-item>
                    </v-badge>
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
            <v-list nav dense class="pa-5">
                <v-icon color="blue mb-2 d-flex" style="display: flex; justify-content: center;">mdi-cart</v-icon>
                <v-spacer></v-spacer>
                <v-header class="font-weight-bold" style="display: flex; justify-content: center;">Keranjang</v-header>
                <v-divider class="mt-2 mb-2" style="border-color: black;"></v-divider>
                <v-card class="mt-3" v-if="cart.length < 1">
                    <v-card-subtitle class="py-5 text-center">---Belum ada pembelian---</v-card-subtitle>
                </v-card>
                <template  >
                    <div v-for="(item, i) in cart" :key="i">
                        <v-divider v-if=" i > 0"></v-divider>
                        <v-list-item >
                            <v-list-item-avatar>
                            <v-img :src="item.buku.cover"></v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                            <v-list-item-subtitle v-html="item.buku.judul"></v-list-item-subtitle>
                            <v-list-item-title v-html="formater.format(item.buku.harga * item.jumlah)"></v-list-item-title>
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
                    </div>
                </template>
            </v-list>
            <template v-slot:append v-if="cart.length > 0">
                <div class="pa-2">
                <v-btn color="success" block @click="dialog = true">
                    Checkout
                </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main>
            <v-container style="max-width: 100%; padding: 0;">
                <router-view  :key="$route.fullPath"></router-view>
            </v-container>
        </v-main>
        <Footer />

        <v-dialog v-model="dialog" max-width="600px">
            <v-card class="p-2">
              <v-card-title>Checkout</v-card-title>
              <v-card-sub-title>
                <v-list nav dense>
                    <template>
                        <div v-for="(item, i) in cart" :key="i">
                            <v-list-item >
                                <v-list-item-avatar class="ms-2">
                                    <v-img :src="item.buku.cover"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                <v-list-item-subtitle v-html="item.buku.judul"></v-list-item-subtitle>
                                <v-list-item-title v-html="formater.format(item.buku.harga * item.jumlah)"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider class="m-0"></v-divider>
                        </div>
                    </template>
                </v-list>
              </v-card-sub-title>
              <v-card-title style="display: flex; justify-content: center;">Total : {{ formater.format(cart.reduce((total,x) => total + (x.jumlah * x.buku.harga),0)) }}</v-card-title>
              <v-card-action style="display: flex; justify-content: center;">
                <v-spacer></v-spacer>
                <v-btn color="success darken-1" text @click="dialog = false; addTransaksi()">Iya</v-btn>
                <v-btn color="red darken-1" text @click="dialog = false">Tidak</v-btn>
                <v-spacer></v-spacer>
              </v-card-action>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="alert.show" :color="alert.color" timeout="2000" bottom>{{ alert.msg }}</v-snackbar>
    </div>
</template>

<script setup>
/* eslint-disable */
import Footer from '@/components/FooterContent.vue'
import { useBukuStore } from '@/stores/buku';
import { useKeranjangStore } from '@/stores/keranjang';
import { useTransaksiStore } from '@/stores/transaksi';
import { useUserStore } from '@/stores/user';
import { computed, onMounted, ref } from 'vue';

const store = useUserStore()
const cartStore = useKeranjangStore()
const tranStore = useTransaksiStore()
const bukuStore = useBukuStore()

const dialog = ref(false)
const errors = ref({})
const drawer = ref(false)
const alert = ref({})

const user = computed(() => store.user);
const auth = computed(() => store.token);
const cart = computed(() => cartStore.keranjang);

//formater
const formater = new Intl.NumberFormat("id-ID", { style: "currency", currency : "IDR", minimumFractionDigits: 0 })

async function logout(){
    const res = await store.logout()
    await cartStore.get()
    cartStore.keranjang = []
    await tranStore.get()
    tranStore.transaksi = []
}

async function editChart (data) {
    if(data.jumlah > data.buku.stok) {
        alert.value = {color: 'red', msg: "Stok tidak cukup", show:true }
        data.jumlah = data.buku.stok
        return
    }
    if(data.jumlah > 0) await cartStore.save(data) 
    else await cartStore.delete(data.buku_id) 
    await cartStore.get()
}

async function addTransaksi () {
    await tranStore.insert({
        details : cartStore.keranjang.map(x => {return {...x, subtotal : x.buku.harga * x.jumlah} }),
        total : cartStore.keranjang.reduce((total,x) => total + (x.jumlah * x.buku.harga),0)
    }) 
    await cartStore.clear()
    await cartStore.get()
    await tranStore.get()
    await bukuStore.get()
    await bukuStore.getById(bukuStore.selected.id)
    alert.value = {color: 'green', msg: "Berhasil checkout", show:true }
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