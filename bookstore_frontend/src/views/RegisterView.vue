<template>
  <v-container fill-height fluid >
    <v-card
      elevation="2"
      class="mx-auto pa-4"
    >
      <v-text-field
          label="username"
          v-model="user.username"
          :error-messages="errors.username"
        >
        </v-text-field>
      <v-text-field
          label="nama"
          v-model="user.nama"
          :error-messages="errors.nama"
        >
        </v-text-field>
      <v-text-field
          label="Email"
          v-model="user.email"
          :error-messages="errors.email"
        >
        </v-text-field>
      <v-text-field
          label="no_hp"
          v-model="user.no_hp"
          :error-messages="errors.no_hp"
        >
        </v-text-field>
      <v-text-field
          label="Password"
          v-model="user.password"
          :error-messages="errors.password"
        >
        </v-text-field>
      <v-file-input v-model="user.foto" :error-messages="errors.foto" label="Foto" ></v-file-input>
      <v-btn block :loading="isLoading" @click="login()">Login</v-btn>
    </v-card>
  </v-container>
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
    login () {
      this.isLoading = true
      axios.post('http://127.0.0.1:8000/api/'+"register", this.user, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
      } )
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
