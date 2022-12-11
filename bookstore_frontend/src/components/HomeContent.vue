<template>
  <div>
    <img src="../assets/Main-Banner.jpg" alt="Main Banner Armedia" width="100%">
    <v-card v-for="n in 5" :key="n" :loading="loading" class="my-5" max-width="165">
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
  </div>
</template>
<script>
export default {
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
