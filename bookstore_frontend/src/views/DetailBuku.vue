<template>
  <div class="detailBuku">
    <v-breadcrumbs :items="items" divider="/" class="mb-5"></v-breadcrumbs>
    <v-row>
      <v-col cols="3">
        <v-card class="p-4 mx-5 mb-5">
          <v-img max-width="100%" :src="buku?.cover"></v-img>
        </v-card>
        <v-divider class="m-0" style="border-color: black;"></v-divider>
        <p class="m-2" style="text-align: center;">Stok : {{ buku?.stok }}</p>
        <v-divider class="m-0" style="border-color: black;"></v-divider>
      </v-col>
      <v-col cols="6">
        <p class="mb-0" style="font-size: 20px; color: slategray;">{{ buku?.penulis?.nama }}</p>
        <p class="mb-0" style="font-size: 30px;">{{ buku?.judul }}</p>
        <v-row>
          <div class="d-flex flex-row">
            <v-rating :value="buku?.rating" color="amber" dense half-increments readonly size="14"></v-rating>
            <div class="grey--text ms-4">
              {{ buku?.rating }} ({{ buku?.review?.length }})
            </div>
          </div>
        </v-row>
        <v-row class="p-2">
          <v-card style="background-color: azure;" elevation="0" class="p-0">
            <v-card-text >
              Harga :
              <v-card-title class="p-0 font-weight-bold" style="font-size: 20px;"> {{ formater.format(buku?.harga) }}</v-card-title>
            </v-card-text>
            <v-divider class="m-0" style="color: black;"></v-divider>
          </v-card>
        </v-row>
        <!-- <p class="mt-5 mb-0 font-weight-bold">Deskripsi Buku</p>
                <p>
                    Novel karya J. S Khairen yang berjudul Melangkah bertemakan tentang petualangan di Indonesia.
                    Tidak hanya itu, cerita dalam novel ini juga mengutamakan kisah pahlawan. Berbeda dari karya-karya yang sebelumnya,
                    di novel ini Khairen memberi sedikit imajinasi yang ia tanamkan. Terdapat 36 episode dan 5 babak.
                </p> -->
        <p class="mt-5 mb-0 font-weight-bold">Sinopsis</p>
        <p>
          {{ buku?.sinopsis }}
        </p>
        <p class="mt-5 mb-0 font-weight-bold">Detail</p>
        <v-row class="ms-2">
          <v-col cols="6">
            <p>Bahasa : {{ buku?.bahasa }}</p>
            <p>Jumlah Halaman : {{ buku?.halaman }}</p>
            <p>Genre : {{ buku?.genre?.nama }}</p>
          </v-col>
          <v-col cols="6">
            <p>Penulis : {{ buku?.penulis?.nama }}</p>
            <p>Penerbit : {{ buku?.penerbit }}</p>
            <p>Tanggal Terbit : {{ buku?.tgl_terbit }}</p>
          </v-col>
        </v-row>

        <v-btn class="mt-4 mb-4" color="success" to="/login" v-if="!userData.nama" outlined>Login untuk membeli</v-btn>
        <v-btn class="mt-4 mb-4" color="success" @click="region = true"
          v-if="userData.nama && !reCartStore?.findBuku(buku?.id)">Pilih Buku ini</v-btn>
        <v-card>
          <v-card-title>Review </v-card-title>
          <v-list-item v-if="
            userData.nama
            && !buku.review.find(x => x.user_id == userData.id)
            && transData.find(tran => tran.details.some(detail => detail.buku_id == buku.id))
            ">
            <v-list-item-avatar>
              <v-img alt="Avatar" :src="userData.foto"></v-img>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>
                <div class="d-flex flex-row">
                  <v-rating v-model="review.nilai" color="amber" dense half-increments size="14"></v-rating>
                  <div class="grey--text ms-4">{{ review.nilai }}</div>
                </div>
              </v-list-item-title>
              <v-list-item-subtitle>
                <v-text-field label="Komentar" placeholder="Tulis Reviewmu tentang buku ini disini..."
                  v-model="review.komentar"></v-text-field>
                <v-btn @click="saveReview">Kirim</v-btn>
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <!-- review -->
          <v-list three-line>
            <template>
              <div v-for="(rev, i) in buku.review" :key="i">
                <v-divider v-if="i > 0" ></v-divider>

                <v-list-item >
                  <v-list-item-avatar>
                    <v-img :src="rev.user.foto"></v-img>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-subtitle v-html="rev.user.nama"></v-list-item-subtitle>
                    <v-list-item-subtitle>
                      <div class="d-flex flex-row">
                        <v-rating v-model="rev.nilai" color="amber" dense half-increments size="14"></v-rating>
                        <div class="grey--text ms-4">{{ rev.nilai }}</div>
                      </div>
                    </v-list-item-subtitle>
                    <v-list-item-title v-html="rev.komentar"></v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </div>
            </template>
          </v-list>

        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card class="my-3">
          <v-card-title >Pembelian</v-card-title>
          <v-divider class="m-0" style="border-color: black;"></v-divider>
          <span v-if="!reCartStore.findBuku(buku?.id)">
            <v-card-subtitle class="py-2 text-center">---Belum ada pembelian---</v-card-subtitle>
          </span>
          <span v-else>
            <v-card-text style="font-size: 20px;">
              <div class="mb-2">
                {{ buku?.judul }}
              </div>
              <v-spacer></v-spacer>
              <v-btn class="mx-2" fab dark x-small color="primary" elevation="1" @click="
                reCartStore.findBuku(buku?.id).jumlah--; editChart(reCartStore.findBuku(buku?.id))">
                <v-icon>mdi-minus</v-icon>
              </v-btn>
              {{ reCartStore?.findBuku(buku?.id).jumlah }}
              <v-btn class="mx-2" fab dark x-small color="primary" elevation="1" @click="
                reCartStore.findBuku(buku?.id).jumlah++; editChart(reCartStore.findBuku(buku?.id))">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </v-card-text>
            <v-divider class="m-0" style="border-color: black;"></v-divider>
            <v-card-text style="font-size: 15px;">
              Total Harga : <b>{{ formater.format(buku?.harga * reCartStore.findBuku(buku?.id).jumlah) }}</b>
            </v-card-text>
            <v-divider class="m-0" style="border-color: black;"></v-divider>
            <v-card-action>
              <v-btn color="blue darken-1" text block> Bayar </v-btn>
            </v-card-action>
          </span>
        </v-card>
      </v-col>
    </v-row>

    <v-card color="#CCDFEF" class="my-5" elevation="0">
      <v-card-title class="text-center">Rekomendasi Untukmu</v-card-title>
      <v-card-subtitle>
        <cat-carousel :items="data" :item-per-page="7"
          :indicators-config="{ activeColor: '#000', size: 8, color: '#d1d1d1', hideIndicators: false }">
          <template slot="item" slot-scope="{data}">
            <v-card elevation="0" class="my-2" outlined :to="'/detail/' + data.id">
              <v-img max-height="200px" :src="data.cover"></v-img>
              <v-card-text class="font-weight-bold">{{ data.judul }}</v-card-text>
            </v-card>
          </template>
        </cat-carousel>
      </v-card-subtitle>
    </v-card>

    <v-dialog v-model="region" max-width="600px">
      <v-card class="pa-4">
        <v-card-title style="display: flex; justify-content: center;">{{ buku?.judul }}</v-card-title>
        <v-divider style="color: black;"></v-divider>
        <v-card-text style="color: black;">
          <p class="mb-0 font-weight-bold">Detail</p>
          <v-row class="ps-4">
            <v-col cols="6">
              <p>Bahasa : {{ buku?.bahasa }}</p>
              <p>Jumlah Halaman : {{ buku?.halaman }}</p>
              <p>Genre : {{ buku?.genre?.nama }}</p>
            </v-col>
            <v-col cols="6">
              <p>Penulis : {{ buku?.penulis?.nama }}</p>
              <p>Penerbit : {{ buku?.penerbit }}</p>
              <p>Tanggal Terbit : {{ buku?.tgl_terbit }}</p>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-title style="display: flex; justify-content: center;">Yakin pilih buku ini untuk dibeli?</v-card-title>
        <v-card-action style="display: flex; justify-content: center;">
          <v-btn color="success darken-1" text @click="addToChart(buku); region = false">Iya</v-btn>
          <v-btn color="red darken-1" text @click="region = false">Tidak</v-btn>
        </v-card-action>
      </v-card>
    </v-dialog>
  </div>
</template>
<script setup>
/* eslint-disable */
import { useBukuStore } from '@/stores/buku';
import { CatCarousel } from 'vue-cat-carousel'
import { computed, onMounted, ref } from 'vue';
import router from '@/router';
import { useKeranjangStore } from '@/stores/keranjang';
import { useUserStore } from '../stores/user';
import { useTransaksiStore } from '@/stores/transaksi';
const loading = ref(false)
const id = computed(() => router.currentRoute.params.id)


const review = ref({ nilai: 0, komentar: "" })
const store = useBukuStore()
const cartStore = useKeranjangStore()
const userStore = useUserStore()
const transaksiStore = useTransaksiStore()

const data = computed(() => store.buku)
const buku = computed(() => store.selected)
const userData = computed(() => userStore.user)
const reCartStore = computed(() => cartStore);
const transData = computed(() => transaksiStore.transaksi)

//formater
const formater = new Intl.NumberFormat("id-ID", { style: "currency", currency : "IDR", minimumFractionDigits: 0 })

async function fetchBuku() {
  loading.value = true
  await store.get()
  let res = await store.getById(id.value)
  console.log("buku",res);
  loading.value = false
}

async function fetchCart () {
  let res = await cartStore.get() 
}

async function fetchTransaksi () {
  let res = await transaksiStore.get() 
  console.log("transa",res);
}

async function addToChart(buku) {
  let res = await cartStore.save({ buku_id: buku?.id, jumlah: 1 })
  await fetchCart()
}

async function editChart(data) {
  if (data.jumlah > 0) await cartStore.save(data)
  else await cartStore.delete(data.buku_id)
  await fetchCart()
}

async function saveReview() {
  await store.addReview({ ...review.value, buku_id: buku?.value.id })
  await fetchBuku()
}

onMounted(async () => {
  await fetchBuku()
  await fetchCart()
  await fetchTransaksi()
})

const region = ref(false)

const items = [
  {
    text: 'Home',
    disabled: false,
    href: '/'
  },
  {
    text: 'Detail Buku',
    disabled: false,
    href: ''
  }
]
</script>
<style>
.detailBuku {
  margin: 0 90px;
}

@media screen and (max-width: 1316px) {
  .detailBuku {
    margin: 0 10px;
  }
}
</style>
