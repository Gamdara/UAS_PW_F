<template>
  <div id="background">
    <v-container fill-height fluid>
      <v-card elevation="2" class="mx-auto pa-4 register">
        <h2 class="text-center " style="font-weight: 900;">DAFTAR</h2>
        <p class="text-center mb-5">Selamat Datang di <b>Armedia</b>,<br>Toko buku termurah dan terlengkap di Yogyakarta</p>
        <v-text-field label="Nama" v-model="user.nama" placeholder="Masukkan Nama" :error-messages="errors.nama" outlined></v-text-field>
        <v-text-field label="Username" v-model="user.username" placeholder="Masukkan Username" :error-messages="errors.username" outlined></v-text-field>
        <v-text-field label="Email" v-model="user.email" placeholder="Masukkan Email" :error-messages="errors.email" outlined></v-text-field>
        <v-text-field label="No Handphone" v-model="user.no_hp" placeholder="Masukkan No Handphone" :error-messages="errors.no_hp" outlined></v-text-field>
        <v-text-field label="Password" type="password" v-model="user.password" placeholder="Masukkan Password" :error-messages="errors.password" outlined></v-text-field>
        <v-file-input v-model="user.foto" :error-messages="errors.foto" placeholder="Upload Foto" label="Upload Foto" outlined show-size dense></v-file-input>
        <v-btn block :loading="isLoading" @click="regist()" outlined color="success">Daftar</v-btn>
        <p class="mt-3 text-center">Sudah Punya Akun? <router-link to="/login">Masuk</router-link></p>
      </v-card>
    </v-container>
  </div>
</template>
<script setup>
/* eslint-disable */
import { useUserStore } from '@/stores/user';
import { ref } from 'vue';

const store = useUserStore()

const isLoading = ref(false)

const user = ref({
  nama: "",
  username: "",
  email: "",
  no_hp: "",
  password: ""
})

const errors = ref({})

async function regist(){
  isLoading.value = true
  let res = await store.register(user.value) 
  console.log(res);
  errors.value = res.data.errors || {}
  isLoading.value = false
}

</script>
<style>
  .register{
    /* margin-top: 100px; */
    margin: auto;
    width: 550px;
    /* max-width: 550px; */
    /* text-align: center !important; */
    padding: 20px;
    border: 8px solid rgb(5,111,111);
    border-radius: 3px;
  }

  #background {
    background: url(https://img.freepik.com/free-vector/digital-technology-background-with-abstract-wave-border_53876-117508.jpg?w=2000);
    min-height: 92vh;
    display: flex;
  }

  @media screen and (max-width: 1316px){
    .register{
      border: 5px solid rgb(5,111,111);
    }
  }
</style>

