<template>
  <div>
    <div class="banner-home">
      <v-row align="center" justify="center">
        <v-col class="welcome-logo text-center" cols="12">
          <img src="../assets/Armedia-iconSmall.png" alt="Logo">
          <h1 class="welcome-text mt-1">TOKO BUKU TERLENGKAP DAN TERPERCAYA<br>HANYA DI ARMEDIA </h1>
          <h5 class="welcome-sub-text">SELALU DI HATI PARA PEMBUKU DI INDONESIA</h5>
        </v-col>
      </v-row>
    </div>
    <carousel :loop="true" :nav="false" :autoplay="true" :margin="10" :responsive="{0:{items:4},600:{items:10}}" :rewind="false" :dots="false">
      <div v-for="slide in slides" :key="slide" style="background-color: white; margin: 5px 0; z-index: 0;">
        <img :src="slide" style="object-fit: contain;" width="100px" height="70px">
      </div>
    </carousel>
    <div class="carousel-home">
      <HomeContent />
    </div>
    <!-- <Footer/> -->

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
import HomeContent from '@/components/HomeContent.vue'
import carousel from 'vue-owl-carousel'
// import Footer from '@/components/FooterContent.vue'
/* eslint-disable */
// import client from '@/api/request'
export default {
  name: 'HomeView',
  components: {
    HomeContent,
    carousel
    // Footer
  },
  data () {
    return {
      slides: [
        'https://jobsumbar.com/wp-content/uploads/2019/11/Lowongan-Kerja-Padang-PT.-Tiga-Serangkai-Pustaka-Mandiri-Terbaru.png',
        'http://sptsmg.files.wordpress.com/2012/10/logo-penerbit-erlangga.jpg',
        'https://static.wixstatic.com/media/46a0f7_14461247df4d4739953ed8bde565b97c~mv2.png',
        'https://penerbitdeepublish.com/wp-content/uploads/2020/08/Logo-Baru-April.png',
        'https://www.kibrispdr.org/data/760/logo-penerbit-buku-4.png',
        'https://octacintabuku.files.wordpress.com/2013/02/logo-gm.jpg',
        'https://www.gramedia.com/blog/content/images/2017/09/Logo-Baru-Grasindo-2-1.jpg',
        'https://cdn-brilio-net.akamaized.net/community/community-news/2019/10/23/aba345c938e59f1d58f300777faae827/22-image_1571753002_5daf0c2a4fbaf.jpg',
        'https://i0.wp.com/penerbitgraniti.com/wp-content/uploads/2017/02/Graniti-Logo-200.png?fit=200%2C200&ssl=1',
        'https://penerbitindependen.com/wp-content/uploads/2020/04/Logo-untuk-Website-Penerbit-Independen.jpg',
        'https://www.gramedia.com/blog/content/images/2017/09/elexmedia-1.jpg',
        'https://amertamedia.co.id/wp-content/uploads/2021/10/logo-memanjang-warna.png'
      ]
    }
  },
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
<style>
.welcome-logo img {
  height: 200px;
  margin-bottom: 10px;
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}
.carousel-home{
  margin: 0 90px;
}
.banner-home{
  background: url(https://png.pngtree.com/thumb_back/fh260/background/20220216/pngtree-banner-background-image_931356.jpg);
  color: aliceblue;
  height: 400px;
}
.welcome-text{
  margin-top: 70px;
  font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
  font-weight: 700;
}
.welcome-sub-text{
  font-style: italic;
  font-family: Georgia, Times, 'Times New Roman', serif;
}
@media screen and (max-width: 1316px) {
  .welcome-logo img {
    height: 150px;
  }
  .carousel-home{
    margin: 0 0;
  }
}
</style>
