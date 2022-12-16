<template>
    <div class="detailBuku">
        <v-breadcrumbs :items="items" divider="/" class="mb-5"></v-breadcrumbs>
        <v-row>
            <v-col cols="3" >
                <v-card class="p-4 mx-5 mb-5">
                    <v-img max-width="100%" src="https://cdn.gramedia.com/uploads/items/9786020523316_Melangkah_UV_Spot_R4-1__w150_hauto.jpg"></v-img>
                </v-card>
            </v-col>
            <v-col cols="6">
                <p class="mb-0" style="font-size: 20px; color: slategray;">Js. Khairen</p>
                <p class="mb-0" style="font-size: 30px;">Melangkah</p>
                <v-row>
                  <v-rating :value="4.5" color="amber" dense half-increments readonly size="14"></v-rating>

                  <div class="grey--text ms-4">
                    4.5 (413)
                  </div>
                </v-row>
                <p class="mt-5 mb-0 font-weight-bold">Deskripsi Buku</p>
                <p>
                    Novel karya J. S Khairen yang berjudul Melangkah bertemakan tentang petualangan di Indonesia.
                    Tidak hanya itu, cerita dalam novel ini juga mengutamakan kisah pahlawan. Berbeda dari karya-karya yang sebelumnya,
                    di novel ini Khairen memberi sedikit imajinasi yang ia tanamkan. Terdapat 36 episode dan 5 babak.
                </p>
                <p class="mt-5 mb-0 font-weight-bold">Sinopsis</p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Nulla ultricies maximus enim, sit amet pharetra tortor ultrices id.
                    Cras turpis tellus, lobortis quis urna a, suscipit tincidunt sem.
                    Sed mattis sagittis dignissim. Aenean aliquet at eros sed suscipit.
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;
                    Proin auctor scelerisque tincidunt. Nam ut neque eget nulla laoreet vulputate.
                    Mauris sagittis arcu vel enim efficitur suscipit. Donec ornare, metus ut blandit malesuada,
                    lectus est tristique orci, sit amet condimentum nunc elit ac lacus. Nam interdum sollicitudin erat,
                    ac tristique sem sodales ut. Praesent vel commodo sapien. Vivamus dolor augue,
                    tincidunt non lectus at, commodo egestas urna. Aenean turpis felis, bibendum eget urna eget,
                    egestas scelerisque ligula. Pellentesque et quam vel turpis semper vestibulum.
                    In tincidunt purus iaculis, tincidunt felis vel, placerat eros. In vel ante egestas,
                    pharetra dolor ut, vehicula quam. Aliquam varius sit amet orci quis mollis. Suspendisse
                    mauris mauris, luctus ut lacus et, condimentum elementum erat. Vivamus est elit, placerat
                    nec massa at, semper sagittis lacus. Suspendisse blandit fringilla porttitor.
                    Vivamus sit amet purus et purus molestie mattis a sit amet nibh. Nulla ultrices,
                    augue vitae convallis laoreet, velit ipsum laoreet mauris, in volutpat lacus eros et massa.
                </p>
                <p class="mt-5 mb-0 font-weight-bold">Detail</p>
                <p>
                    Lorem
                </p>
                <v-btn color="success" @click="region=true">Pilih Buku ini</v-btn>

            </v-col>
            <v-col cols="3">
                <v-card>
                    <v-card-title>Pilih dulu barangnyo</v-card-title>
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
                <v-text-field label="Username" placeholder="Masukkan Username" ></v-text-field>
                <v-card-action>
                    <v-btn>Oke</v-btn>
                </v-card-action>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import { CatCarousel } from 'vue-cat-carousel'

export default {
  name: 'DetailBuku',
  components: {
    CatCarousel
  },
  data: () => ({
    region: false,
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
  })
}
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
