<template>
  <v-container fill-height fluid >
    <v-card
      elevation="2"
      class="mx-auto pa-4"
    >
      <v-text-field
          label="Email"
          v-model="user.email"
          :error-messages="errors.email"
        >
        </v-text-field>
      <v-text-field
          label="Password"
          v-model="user.password"
          :error-messages="errors.password"
        >
        </v-text-field>
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
      axios.post('http://127.0.0.1:8000/api/'+"login", JSON.stringify(this.user), {
          headers: {
            'Content-Type': 'application/json'
          }
      } )
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
