<template>
  <div id="background">
    <v-container fill-height fluid>
      <v-card elevation="2" class="login animate__animated animate__fadeInDown">
        <h2 class="text-center " style="font-weight: 900;">MASUK</h2>
        <p class="text-center mb-5">Selamat Datang di <b>Armedia</b>,<br>Toko buku termurah dan terlengkap di Yogyakarta<br>Silakan Masuk untuk melanjutkan...</p>
        <v-text-field label="Username" v-model="user.email" placeholder="Masukkan Username" outlined :error-messages="errors.email"></v-text-field>
        <v-text-field type="password" label="Password" v-model="user.password" placeholder="Masukkan Password" outlined :error-messages="errors.password"></v-text-field>
        <v-btn block class="m-0" outlined color="success" :loading="isLoading" @click="login">Masuk</v-btn>
        <p class="mt-3 text-center">Belum punya akun? <router-link to="/register">Daftar</router-link></p>
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
  email: "",
  password: ""
})

const errors = ref({})

async function login(){
  isLoading.value = true
  let res = await store.login(user.value) 
  errors.value = res.data.errors || {}
  isLoading.value = false
}

</script>
<style>
  .login{
    /* margin-top: 100px; */
    margin: auto;
    width: 550px;
    /* max-width: 550px; */
    /* text-align: center !important; */
    padding: 20px;
    border: 7px solid rgb(5,111,111) !important;
    background-color: rgb(255, 255, 255, 0.5) !important;
  }

  #background {
    background: url(https://img.freepik.com/free-vector/digital-technology-background-with-abstract-wave-border_53876-117508.jpg?w=2000);
    height: 80vh;
    display: flex !important;
  }

  @media screen and (max-width: 1316px){
    .login{
      border: 5px solid rgb(5,111,111);
    }
  }
</style>

