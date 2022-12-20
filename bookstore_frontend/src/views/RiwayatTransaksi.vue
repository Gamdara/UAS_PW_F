<template>
    <v-main class="list">
        <h3 class="text-h3 font-weight-medium mb-5"> Riwayat Pembelian </h3>
        
        <v-card>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details>
                </v-text-field>
                <v-spacer></v-spacer>
            </v-card-title>
  
            <v-data-table :headers="headers" :items="riwayats" :search="search" > 
              <template v-slot:[`item.image`]="{ item }">
                  <img :src="item.image">
              </template>
              </v-data-table> 
  
        </v-card> 
  
        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }}</v-snackbar>
    </v-main> 
</template>
<script>
/* eslint-disable */
  export default {
    name: "ListBuku",
    data() { 
        return {
            load: false,
            url: null,
            image: null,
            snackbar: false,
            error_message: '',
            color: '',
            search: null, 
            dialog: false, 
            headers: [
                { text: "Kode", align: "start", sortable: true, value: "kode"},
                { text: "Tanggal", value: "tanggal" },
                { text: "Total", value: "total"},
                { text: "Cover Buku", value: "image" },
                { text: "Judul", value: "judul" },
                { text: "Jumlah Beli", value:"jumlah"},
                { text: "Subtotal", value:"subtotal"},
            ],
            riwayats: [
              { 
                kode: 1,
                tanggal: '2022-12-12',
                total: 10.000,
                image: "https://upload.wikimedia.org/wikipedia/id/5/56/Harry_potter_deathly_hallows_US.jpg",
                judul: "Harry Poter",
                jumlah: 9,
                subtotal: 60.000
              },
            ],
            form:{
                Kode: "",
                Tanggal: "",
                Total: "",
                image: "",
                Judul: "",
                Jumlah: "",
                Subtotal: "",
            },
        };
    },
    methods: { 
      Preview_image() {
        this.url= URL.createObjectURL(this.image)
      },
        readData() {
            var url = this.$api + '/riwayat';
            this.$http.get(url, {
                headers:{
                    'Authorization' : 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {
                this.courses = response.data.data;
            })
        },
    },
    computed: {
        formTitle() {
            return this.inputType;
        },
    },
    mounted() {
        this.readData();
    },
  };
</script>