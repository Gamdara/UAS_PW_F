<template>
  <div>
    <!-- ini asli -->
    <v-row v-if="!isLoading">
      <v-col v-for="buku in datas" :key="buku.id">
        <v-card max-width="250px" >
          <v-img
            class="white--text align-end"
            height="200px"
            :src="buku.cover"
          >
        </v-img>
        <v-card-title>{{buku.judul}}</v-card-title>
        <v-card-subtitle class="pb-0">
          {{buku.sinopsis}}
        </v-card-subtitle>
        <v-card-actions >
          <v-btn
            color="orange"
            text
          >
            add to chart
          </v-btn>
        </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <!-- loading -->
    <v-row v-if="isLoading">
      <v-col  v-for="x in 8" :key="x">
        <v-card width="250px" >
          <v-skeleton-loader
            class="mx-auto"
            max-width="300"
            type="card"
          ></v-skeleton-loader>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import client from '@/api/request'
import { onMounted, ref } from 'vue'
/* eslint-disable */
// import client from '@/api/request'
export default {
  name: 'HomeView',
  setup() {
    let datas = ref([])
    let isLoading = ref(false)

    onMounted (() => {
      fetchAll()
    })

    function fetchAll () {
      isLoading.value = true
      client.get('bukus')
      .then(response => {
        isLoading.value = false
        datas.value = response.data.data
      })
      .catch(error => {
        isLoading.value = false
        console.log(error.response.data)
      })
    }

    return {
      datas,
      isLoading
    }
  }
}
</script>
