<template>
  <div>
    <img src="../assets/Main-Banner.jpg" alt="Main Banner Armedia" width="100%">
    <div>
      <v-card outlined class="my-5">
        <v-row>
          <v-col class="py-0">
            <v-card-title>Buku Terlaris</v-card-title>
          </v-col>
          <v-col class="py-0">
            <router-link to="/" style="text-align: end;"> Selengkapnya>> </router-link>
          </v-col>
        </v-row>
        <v-card-subtitle >
          <!-- asli -->
          <carousel v-if="!loading" :loop="false" :center="false" :mouseDrag="true" :stagePadding="5" :autoHeight="true" :nav="false" :autoplay="true" :margin="10" :responsive="{0:{items:2},600:{items:7}}" :rewind="true" :dots="false">
            <v-card v-for="(buku,i) in data" :key="buku.id" class="my-5" max-width="165" :to="'/detail/'+buku.id">
              <!-- :to='"/detail/"+buku.id' -->
              <template slot="progress">
                <v-progress-linear color="deep-purple" height="3" indeterminate></v-progress-linear>
              </template>

              <v-img max-height="200px" :src="buku.cover"></v-img>

              <v-card-title>{{buku.judul}}</v-card-title>
              <v-card-subtitle>{{buku.penulis.nama}}</v-card-subtitle>

              <v-card-text>
                <div class="text-subtitle-1">
                  Rp {{buku.harga}}
                </div>
                <v-row>
                  <v-rating :value="buku.rating" color="amber" dense half-increments readonly size="14"></v-rating>

                  <!-- <div class="grey--text ms-4">
                    4.5 (413)
                  </div> -->
                </v-row>
              </v-card-text>

              <v-card-actions>
                <!-- <v-row> -->
                  <v-btn v-if="!reCartStore.findBuku(buku.id)" color="deep-purple lighten-2" text @click="addToChart(buku,i); " block >
                    BELI
                  </v-btn>
                  <v-text-field
                    type="number"
                    prepend-icon="mdi-map-marker"
                    append-outer-icon="mdi-map-marker"
                    v-if="reCartStore.findBuku(buku.id)"
                    :value="reCartStore.findBuku(buku.id).jumlah"
                    @input="
                    reCartStore.findBuku(buku.id).jumlah = $event
                    editChart(reCartStore.findBuku(buku.id))
                    "

                    @click:prepend="
                    reCartStore.findBuku(buku.id).jumlah--;
                    editChart(reCartStore.findBuku(buku.id))
                    "
                    @click:append-outer="
                    reCartStore.findBuku(buku.id).jumlah++;
                    editChart(reCartStore.findBuku(buku.id))
                    "
                  ></v-text-field>
                <!-- </v-row> -->
              </v-card-actions>
            </v-card>
          </carousel>
        <!-- skeleton -->
        <!--
          <carousel v-if="loading" :loop="false" :center="false" :mouseDrag="true" :stagePadding="5" :autoHeight="true" :nav="false" :autoplay="true" :margin="10" :responsive="{0:{items:2},600:{items:7}}" :rewind="true" :dots="false">
            <v-card v-for="n in 10" :key="n" class="my-5" max-width="165">
              <v-skeleton-loader
                class="mx-auto"
                max-width="165"
                type="card"
              ></v-skeleton-loader>
            </v-card>
          </carousel> -->
        </v-card-subtitle>
      </v-card>
    </div>
  </div>
</template>
<script setup>
/* eslint-disable */
import { useBukuStore } from '@/stores/buku';
import { useKeranjangStore } from '@/stores/keranjang';
import { computed, onMounted,  reactive,  ref } from 'vue'
import carousel from 'vue-owl-carousel'
  const loading = ref(false)
  const store = useBukuStore()
  const data = computed(() => store.buku);
  const cartStore = useKeranjangStore()
  const reCartStore = computed(() => cartStore);
  
  async function fetchBuku () {
    loading.value = true
    await store.get() 
    loading.value = false
  }

  async function fetchCart () {
    let res = await cartStore.get() 
    console.log(res);
  }

  async function fetchAll () {
    await fetchCart()
    await fetchBuku()
  }

  async function addToChart (buku, idx) {
    let res = await cartStore.save({ buku_id : buku.id, jumlah : 1 }) 
    await fetchCart()
  }

  async function editChart (data) {
    if(data.jumlah > 0) await cartStore.save(data) 
    else await cartStore.delete(data.buku_id) 
    await fetchCart()
  }

  onMounted(() => {
    fetchAll()
  })
</script>
