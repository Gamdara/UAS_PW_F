<template>
    <v-main class="profil" style="height: 100%">
        <div class="d-flex justify-content-center mt-16">
            <v-card persistent min-width="400px" elevation="8">
        <v-card-title class="backgroundhead">
          <span class="headline"><b>Profil</b></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field v-model="user.nama" readonly label="Name"></v-text-field>
            <v-text-field v-model="user.password" readonly label="Username"></v-text-field>
            <v-text-field v-model="user.email" readonly label="Email"></v-text-field>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="open"> Edit Profile </v-btn>
        </v-card-actions>
      </v-card>
        </div>
        <v-dialog v-model="dialog" persistent width="400px">
      <v-card>
        <v-card-text>
          <v-container>
            <v-text-field v-model="userEdit.nama" label="Nama" required></v-text-field>
            <v-text-field v-model="userEdit.password" label="Password" required></v-text-field>
            <v-text-field v-model="userEdit.email" label="Email" required></v-text-field>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
          <v-btn color="blue darken-1" text @click="simpan"> Save </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom> {{ error_message }} </v-snackbar>
    </v-main>
</template>

<style scoped>
.backgroundhead {
  background-color: #d0d0d0;
}
</style>

<script>
/* eslint-disable */

export default {
    name: 'Profil',
    data() {
        return {
            load: false,
            snackbar: false,
            error_message: '',
            color: '',
            dialog: false,
            user: {
                nama: null,
                password: null,
                email: null,
            },
            userEdit: {
                nama: null,
                password: null,
                email: null,
            },
        };
    },
    methods: {
        readData(){
            var url = this.$api + "/user/" + localStorage.getItem("id");
            this.$http
            .get(url, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            })
            .then((response) => {
                this.user.nama = response.data.data.nama;
                this.user.email = response.data.data.password;
                this.user.email = response.data.data.email;
            });
        },
        cancel() {
            this.readData();
            this.dialog = false;
        },
        resetForm() {
            this.form = {
                nama: null,
                password: null,
                email: null,
            };
        },
        open() {
            this.dialog = true;
        },
        simpan() {
            let newData = {
                nama: this.userEdit.nama,
                password: this.userEdit.password,
                email: this.userEdit.email,
            };
            var url = this.$api + "/updateProfile/" + localStorage.getItem("id");
            this.load = true;
            this.$http
            .put(url, newData, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                }
            })
            .then((response) => {
                this.error_message = response.data.message;
                this.color = "green";
                this.snackbar = true;
                this.load = false;
                this.dialog = false;
            })
            .catch((error) => {
                this.error_message = error.response.data.message;
                this.color = "red";
                this.snackbar = true;
                this.load = false;
            });
        },
    },
    mounted() {
        this.readData();
    },
};
</script>