<template>
  <div>
    <img src="../assets/Main-Banner.jpg" alt="Main Banner Armedia" width="100%">
    <div>
      <v-card outlined class="my-5">
        <v-card-title>Buku Terlaris</v-card-title>
        <router-link to="/">Selengkapnya>></router-link>
        <v-card-subtitle>
          <carousel :loop="false" :center="false" :mouseDrag="true" :stagePadding="5" :autoHeight="true" :nav="false" :autoplay="true" :margin="10" :responsive="{0:{items:2},600:{items:7}}" :rewind="true" :dots="false">
            <v-card v-for="n in 10" :key="n" :loading="loading" class="my-5" max-width="165">
              <template slot="progress">
                <v-progress-linear color="deep-purple" height="3" indeterminate></v-progress-linear>
              </template>

              <v-img max-height="200px" src="https://cdn.gramedia.com/uploads/items/9786020523316_Melangkah_UV_Spot_R4-1__w150_hauto.jpg"></v-img>

              <v-card-title>Judul Buku</v-card-title>
              <v-card-subtitle>Pengarang</v-card-subtitle>

              <v-card-text>
                <div class="text-subtitle-1">
                  Rp 70.000
                </div>
                <v-row>
                  <v-rating :value="4.5" color="amber" dense half-increments readonly size="14"></v-rating>

                  <!-- <div class="grey--text ms-4">
                    4.5 (413)
                  </div> -->
                </v-row>
              </v-card-text>

              <v-card-actions>
                <v-btn color="deep-purple lighten-2" text @click="reserve" block>
                  BELI
                </v-btn>
              </v-card-actions>
            </v-card>
          </carousel>
        </v-card-subtitle>
      </v-card>
    </div>
  </div>
</template>
<script>
import carousel from 'vue-owl-carousel'
export default {
  components: {
    carousel
  },
  data: () => ({
    loading: false,
    selection: 1
  }),

  methods: {
    reserve () {
      this.loading = true

      setTimeout(() => (this.loading = false), 2000)
    }
  }
}
</script>
