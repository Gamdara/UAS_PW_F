<template>
  <div id="background">
    <v-container fill-height fluid>
      <v-card elevation="2" class="mx-auto register animate__animated animate__fadeIn">
        <h2 class="text-center " style="font-weight: 900;">DAFTAR</h2>
        <p class="text-center mb-5">Selamat Datang di <b>Armedia</b>,<br>Toko buku termurah dan terlengkap di Yogyakarta</p>
        <v-text-field label="Nama" v-model="user.nama" placeholder="Masukkan Nama" :error-messages="errors.nama" outlined></v-text-field>
        <v-text-field label="Username" v-model="user.username" placeholder="Masukkan Username" :error-messages="errors.username" outlined></v-text-field>
        <v-text-field label="Email" v-model="user.email" placeholder="Masukkan Email" :error-messages="errors.email" outlined></v-text-field>
        <v-text-field label="No Handphone" v-model="user.no_hp" placeholder="Masukkan No Handphone" :error-messages="errors.no_hp" outlined></v-text-field>
        <v-text-field label="Password" type="password" v-model="user.password" placeholder="Masukkan Password" :error-messages="errors.password" outlined></v-text-field>
        <v-file-input v-model="user.foto" :error-messages="errors.foto" placeholder="Upload Foto" label="Upload Foto" outlined show-size dense></v-file-input>
        <v-btn block :loading="isLoading" @click="login()" outlined color="success">Daftar</v-btn>
        <p class="mt-3 text-center">Sudah Punya Akun? <router-link to="/login">Masuk</router-link></p>
      </v-card>
    </v-container>
  </div>
</template>
<script>
import axios from 'axios'
/* eslint-disable */
export default {
  name: 'LoginView',

  data: () => ({
    user: {
      email: '',
      password: ''
    },
    errors: {},
    isLoading: false
  }),

  methods: {
    login() {
      this.isLoading = true
      axios.post('http://127.0.0.1:8000/api/' + "register", this.user, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(res => {
          this.isLoading = false
          this.$router.push('/login')
        })
        .catch(err => {
          this.isLoading = false;
          console.log(err);
          this.errors = err.response.data.errors || {}
        })
    }
  }
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
    border: 7px solid rgb(5,111,111) !important;
    background-color: rgb(255, 255, 255, 0.5) !important;
  }

  #background {
    background: url(https://img.freepik.com/free-vector/digital-technology-background-with-abstract-wave-border_53876-117508.jpg?w=2000);
    height: 110vh;
    display: flex;
  }

  @media screen and (max-width: 1316px){
    .register{
      border: 5px solid rgb(5,111,111);
    }
  }
</style>

