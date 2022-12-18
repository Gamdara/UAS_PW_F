<template>
    <div class="detailBuku">
        <v-breadcrumbs :items="items" divider="/" class="mb-5"></v-breadcrumbs>
        <v-row>
            <v-col cols="3" >
                <v-card class="p-4 mx-5 mb-5">
                    <v-img max-width="100%" :src="buku.cover"></v-img>
                </v-card>
            </v-col>
            <v-col cols="6">
                <p class="mb-0" style="font-size: 20px; color: slategray;">{{buku.penulis?.nama}}</p>
                <p class="mb-0" style="font-size: 30px;">{{buku.judul}}</p>
                <v-row>
                  <v-rating :value="buku.rating" color="amber" dense half-increments readonly size="14"></v-rating>

                  <div class="grey--text ms-4">
                    {{buku.rating}}
                  </div>
                </v-row>
                <!-- <p class="mt-5 mb-0 font-weight-bold">Deskripsi Buku</p>
                <p>
                    Novel karya J. S Khairen yang berjudul Melangkah bertemakan tentang petualangan di Indonesia.
                    Tidak hanya itu, cerita dalam novel ini juga mengutamakan kisah pahlawan. Berbeda dari karya-karya yang sebelumnya,
                    di novel ini Khairen memberi sedikit imajinasi yang ia tanamkan. Terdapat 36 episode dan 5 babak.
                </p> -->
                <p class="mt-5 mb-0 font-weight-bold">Sinopsis</p>
                <p>
                    {{buku.sinopsis}}
                </p>
                <p class="mt-5 mb-0 font-weight-bold">Detail</p>
                <p>
                Genre    : {{buku.genre?.nama}}<br>
                Halaman  : {{buku.halaman}}<br>
                Penerbit : {{buku.penerbit}}<br>
                ISBN     : {{buku.isbn}}<br>
                Bahasa   : {{buku.bahasa}}<br>
                Terbit   : {{buku.tgl_terbit}}<br>
                Stok     :  {{buku.stok}}
                </p>
                <v-btn color="success" @click="region=true">Pilih Buku ini</v-btn>

                <v-row class="ms-2">
                  <v-col cols="6">
                    <p>Bahasa : Indonesia</p>
                    <p>Jumlah Halaman : 255</p>
                    <p>Genre : Horror</p>
                  </v-col>
                  <v-col cols="6">
                    <p>Penulis : Js. Khairen</p>
                    <p>Penerbit : Armedia</p>
                    <p>Tanggal Terbit : 11-11-2011</p>
                  </v-col>
                </v-row>
                <v-btn class="mt-4 mb-4" color="success" @click="region=true">Pilih Buku ini</v-btn>
                <p class="mb-0 font-weight-bold">Review</p>
                <v-avatar color="primary" size="36">
                  <v-img
                    alt="Avatar"
                    src="https://avatars0.githubusercontent.com/u/9064066?v=4&s=460"></v-img>
                </v-avatar>
                <v-text-field label="Komentar" placeholder="Tulis Reviewmu tentang buku ini disini..." ></v-text-field>
                <v-btn>Kirim</v-btn>
            </v-col>
            <v-col cols="3">
                <v-card>
                    <v-card-title class="py-3">Pembelian</v-card-title>
                    <v-divider class="m-0" style="border-color: black;"></v-divider>
                    <span v-if="pilihBuku==0">
                      <v-card-subtitle class="py-2 text-center">---Belum ada pembelian---</v-card-subtitle>
                    </span>
                    <span v-else>
                      <v-card-text style="font-size: 20px;">Melangkah
                      <v-spacer></v-spacer>
                      <v-btn class="mx-2" fab dark x-small color="primary" elevation="1" @click="kurangItem">
                        <v-icon>mdi-minus</v-icon>
                      </v-btn>
                      {{ jumlahItem }}
                      <v-btn class="mx-2" fab dark x-small color="primary" elevation="1" @click="tambahItem">
                        <v-icon>mdi-plus</v-icon>
                      </v-btn>
                      </v-card-text>
                    </span>
                </v-card>
            </v-col>
        </v-row>

        <v-card color="#CCDFEF" class="my-5" elevation="0">
            <v-card-title class="text-center">Rekomendasi Untukmu</v-card-title>
            <v-card-subtitle>
                <cat-carousel :items="itemCaro" :item-per-page="7"
                    :indicators-config="{ activeColor: '#000', size: 8, color: '#d1d1d1', hideIndicators: false }">
                    <template slot="item" slot-scope="{data}">
                        <v-card elevation="0" class="my-2 p-3" outlined>
                            <v-img max-height="200px" src="https://cdn.gramedia.com/uploads/items/9786020523316_Melangkah_UV_Spot_R4-1__w150_hauto.jpg"></v-img>
                            <v-card-title>{{data.name}}</v-card-title>
                        </v-card>
                    </template>
                </cat-carousel>
            </v-card-subtitle>
        </v-card>

        <v-dialog v-model="region" max-width="600px">
            <v-card class="p-4">
              <v-card-title>ini Judul Buku</v-card-title>
              <v-card-sub-title>
                <p class="ms-2 mb-0 font-weight-bold">Detail</p>
                <v-row class="ms-4">
                  <v-col cols="6">
                    <p>Bahasa : Indonesia</p>
                    <p>Jumlah Halaman : 255</p>
                    <p>Genre : Horror</p>
                  </v-col>
                  <v-col cols="6">
                    <p>Penulis : Js. Khairen</p>
                    <p>Penerbit : Armedia</p>
                    <p>Tanggal Terbit : 11-11-2011</p>
                  </v-col>
                </v-row>
              </v-card-sub-title>
              <v-card-title class="text-center">Yakin pilih buku ini untuk dibeli?</v-card-title>
              <v-card-action>
                <v-btn color="success darken-1" text @click="pilih">Iya</v-btn>
                <v-btn color="red darken-1" text @click="cancel">Tidak</v-btn>
              </v-card-action>
            </v-card>
        </v-dialog>
    </div>
</template>
<script setup>
/* eslint-disable */
import { useBukuStore } from '@/stores/buku';
import { CatCarousel } from 'vue-cat-carousel'
/* eslint-disable */import { computed, onMounted, ref } from 'vue';
import router from '@/router';
import { useKeranjangStore } from '@/stores/keranjang';
  const loading = ref(false)
  const id = computed(() => router.currentRoute.params.id)
  const store = useBukuStore()
  const buku = ref({})
  const data = computed(() => store.buku)
  const cartStore = useKeranjangStore()
  const reCartStore = computed(() => cartStore);

  async function fetchBuku () {
    loading.value = true
    await store.get() 
    buku.value =await store.getById(id.value)
    loading.value = false
  }

  async function fetchCart () {
    let res = await cartStore.get() 
    console.log(res);
  }

  async function addToChart (buku) {
    let res = await cartStore.save({ buku_id : buku.id, jumlah : 1 }) 
    await fetchCart()
  }

  async function editChart (data) {
    if(data.jumlah > 0) await cartStore.save(data) 
    else await cartStore.delete(data.buku_id) 
    await fetchCart()
  }

onMounted(async ()=>{
  fetchBuku()
  fetchCart()
})

  const region =  ref(false)
    pilihBuku: 0,
    jumlahItem: 0,
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
  const itemCaro = [{ name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }]
</script>
<style>
.detailBuku{
    margin: 0 90px;
}
@media screen and (max-width: 1316px) {
  .detailBuku{
    margin: 0 10px;
  }
}
</style>
<!-- 
export default {
  name: 'DetailBuku',
  components: {
    CatCarousel
  },
  data: () => ({
    region: false,
    pilihBuku: 0,
    jumlahItem: 0,
    items: [
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
    ],
    itemCaro: [{ name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }, { name: 'hans' }, { name: 'sagita' }]
  }),
  methods: {
    pilih() {
      this.pilihBuku = 1;
      this.cancel();
    },
    cancel() {
      this.region = false;
    },
    tambahItem() {
      this.jumlahItem+=1;
    },
    kurangItem() {
      this.jumlahItem-=1;
    }
  }
} -->