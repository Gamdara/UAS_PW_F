
<template>
    <v-main>
        <h1>List <strong>Buku</strong></h1>
        <div class="justify-content-center align-self-center">
              <h2>
                <strong>BEST selling BOOKSTORE of all time,</strong>
                <br />in Your Gadget
              </h2>
              <p>Ayo segera pilih dan pesan buku favorit Anda</p>
            </div>
            <v-container>
              <v-card-title >
                <div class="col">
                  <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" outlined hide details
                    style="margin-top: 30px"></v-text-field>
                <v-spacer></v-spacer>
                </div>
                <v-btn
                  class="ma-2"
                  :loading="loading2"
                  :disabled="loading2"
                  color="primary"
                  @click="loader = 'loading2'"
                  >
                    <v-icon>mdi-eye</v-icon>
                   Lihat Semua
                <template v-slot:loader>
                  <span>Loading...</span>
                </template>
              </v-btn>
            </v-card-title>
                <v-row>
                    <v-col v-for="n in 3" :key="n" cols="12" md="4">
                        <v-card :loading="loading" class="mx-auto my-12" max-width="374">
                            <v-img
                            height="550"
                            width="550"
                            src="https://cdn.gramedia.com/uploads/items/9786020523316_Melangkah_UV_Spot_R4-1__w150_hauto.jpg"
                            ></v-img>

                            <v-card-title> Judul : <h3 class="card-title">Melangkah</h3></v-card-title>
                            <v-divider class="mx-4"></v-divider>
                            <v-card-title><h4>
                                Harga :
                                <strong> Rp. 100000</strong>
                            </h4> </v-card-title>
                            <v-btn
                              class="ma-2"
                              :loading="loading2"
                              :disabled="loading2"
                              color="success"
                              @click="loader = 'loading2'"
                          >
                            Detail Buku
                            <template v-slot:loader>
                              <span>Loading...</span>
                            </template>
                          </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
    </v-main>
</template>
<style>
.text {
    font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}
</style>
<script>

export default {
    data: () => ({
        loading: false,
        selection: 1,
    }),
};
</script>