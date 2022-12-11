<template>
  <div id="background">
    <v-container fill-height fluid>
      <v-card elevation="2" class="login">
        <h2 class="text-center " style="font-weight: 900;">MASUK</h2>
        <p class="text-center mb-5">Selamat Datang di <b>Armedia</b>,<br>Toko buku termurah dan terlengkap di Yogyakarta<br>Silakan Masuk untuk melanjutkan...</p>
        <v-text-field label="Username" v-model="user.username" placeholder="Masukkan Username" outlined :error-messages="errors.username"></v-text-field>
        <v-text-field type="password" label="Password" v-model="user.password" placeholder="Masukkan Password" outlined :error-messages="errors.password"></v-text-field>
        <v-btn block class="m-0" outlined color="success" :loading="isLoading" @click="login()">Masuk</v-btn>
        <p class="mt-3 text-center">Belum punya akun? <router-link to="/register">Daftar</router-link></p>
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
      username: '',
      password: ''
    },
    errors: {},
    isLoading: false
  }),

  methods: {
    login() {
      this.isLoading = true
      axios.post('http://127.0.0.1:8000/api/' + "login", JSON.stringify(this.user), {
        headers: {
          'Content-Type': 'application/json'
        }
      })
        .then(res => {
          this.isLoading = false
          localStorage.setItem('token', res.data.token);
          this.$router.push('/')
        })
        .catch(err => {
          this.isLoading = false;
          this.errors = err.response.data.errors || {}
        })
    }
  }
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
    border: 8px solid rgb(5,111,111);
    border-radius: 3px;
  }

  #background {
    background: url(https://img.freepik.com/free-vector/digital-technology-background-with-abstract-wave-border_53876-117508.jpg?w=2000);
    min-height: 100vh;
    display: flex !important;
  }

  @media screen and (max-width: 1316px){
    .login{
      border: 5px solid rgb(5,111,111);
    }
  }
</style>

