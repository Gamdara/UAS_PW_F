<template>
  <div>
    <v-card class="mt-4">
        <v-card-title>
            <v-list-item-title class="headline">Buku </v-list-item-title>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="data"
            :search="search"
            item-key="name"
            class="elevation-1"
            :loading="isLoading"
            loading-text="Loading..."
            show-expand
        >
            <template v-slot:top>
                <v-row>
                    <v-col cols="11">
                        <v-text-field
                        append-icon="mdi-magnify"
                        v-model="search"
                        label="Search"
                        class="mx-4"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="1">
                        <v-btn fab small color="primary" dark @click="dialog = true; toInsert = true; resetForm()"> <v-icon>mdi-plus</v-icon> </v-btn>
                    </v-col>
                </v-row>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-btn
                    class="ma-2"
                    fab
                    x-small
                    color="success"
                    @click="
                    dialog = true;
                    itemContent = item;
                    setEditItem()
                        ">
                        <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn
                    fab
                    x-small
                    color="error"
                    @click="itemContent = item; confirm = true"
                ><v-icon> mdi-trash-can-outline</v-icon>
                </v-btn>
            </template>
            <template v-slot:expanded-item="{ headers,item }">
                <td :colspan="headers.length">
                    <v-row class="pa-2">
                        <v-col cols="4">
                            <v-img
                            contain
                            max-height="250"
                            :src="item.cover"
                            ></v-img>
                        </v-col>
                        <v-row>
                            <v-col cols="4">
                                <label>{{item.halaman}}</label>
                            </v-col>
                            <v-col cols="4">
                                <label>{{item.penerbit}}</label>
                            </v-col>
                            <v-col cols="4">
                                <label>{{item.isbn}}</label>
                            </v-col>
                            <v-col cols="4">
                                <label>{{item.bahasa}}</label>
                            </v-col>
                            <v-col cols="4">
                                <label>{{item.tgl_lahir}}</label>
                            </v-col>
                            <v-col cols="4">
                                <label>{{item.sinopsis}}</label>
                            </v-col>
                        </v-row>
                    </v-row>
                </td>
            </template>
        </v-data-table>
    </v-card>
    <v-dialog transition="dialog-top-transition" v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-toolbar
            color="brown darken-1"
            dark
            class="headline">{{toInsert ? 'Tambah buku' : 'Edit buku'}}</v-toolbar>
            <v-card-text>
                <v-container>
                    <v-text-field
                        v-model="formContent.judul"
                        label="Judul"
                        required
                    ></v-text-field>
                    <v-select
                        v-model="formContent.genre_id"
                        label="Genre"
                        :items="genres"
                        required
                    ></v-select>
                    <v-select
                        v-model="formContent.penulis_id"
                        label="Penulis"
                        :items="penulis"
                        required
                    ></v-select>
                    <v-text-field v-model="formContent.penerbit" label="penerbit" required></v-text-field>
                    <v-text-field v-model="formContent.halaman" label="halaman" required></v-text-field>
                    <v-text-field v-model="formContent.isbn" label="isbn" required></v-text-field>
                    <v-text-field v-model="formContent.bahasa" label="bahasa" required></v-text-field>
                    <v-text-field v-model="formContent.stok" label="stok" required></v-text-field>
                    <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                            v-model="formContent.tgl_terbit"
                            label="Tanggal lahir"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="formContent.tgl_terbit"
                        @input="menu = false"
                        ></v-date-picker>
                    </v-menu>
                    <v-text-field v-model="formContent.sinopsis" label="sinopsis" required></v-text-field>
                    <v-file-input v-model="formContent.cover" label="sinopsis" required></v-file-input>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="cancel"> Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="dialog = false; toInsert ? insert(formContent) : update(formContent)"> Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="confirm" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline"> Are you sure to delete? </span>
            </v-card-title>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="blue darken-1" text @click="del(itemContent.id); confirm = false"> Yes</v-btn>
                <v-btn color="blue darken-1" text @click="cancel"> No</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
  </div>
</template>

<script>
/* eslint-disable */
import client from '@/api/request';
import { onMounted, reactive, ref } from 'vue';
export default {
    name: 'Adminbuku',
    setup() {
        const data = ref([])
        const genres = ref([])
        const penulis = ref([])
        
        const validation = ref([])
        const isLoading = ref(false)
        //mounted
        onMounted(() => {
            fetchAll()
            client.get('genre')
                .then(response => genres.value = response.data.data.map(x=> {return{text: x.nama, value: x.id}}))
                .catch(error => console.log(error.response.data))
            client.get('penulis')
                .then(response => penulis.value = response.data.data.map(x=> {return{text: x.nama, value: x.id}}))
                .catch(error => console.log(error.response.data))
        })

        function del(id) {
            isLoading.value = true
            client.delete('buku/'+id)
            .then(() => {
                isLoading.value = false
                fetchAll()
            }).catch(error => {
                isLoading.value = false
                console.log(error);
                validation.value = error.response.data
            })
        }

        function update(data) {
            isLoading.value = true
            client.post('buku/'+data.id+'?_method=PUT',data)
            .then(() => {
                isLoading.value = false
                fetchAll()
            }).catch(error => {
                isLoading.value = false
                console.log(error);
                validation.value = error.response.data
            })
        }

        function fetchAll(){
            isLoading.value = true
            client.get('buku')
            .then(response => {
                isLoading.value = false
                data.value = response.data.data
            })
            .catch(error => {
                isLoading.value = false
                console.log(error.response.data)
            })
        }

        function insert(data){
            isLoading.value = true
            console.log(data);
            client.post('buku',data)
            .then(response => {
                isLoading.value = false
                fetchAll()
            })
            .catch(error => {
                isLoading.value = false
                console.log(error.response.data)
            })
        }

        //return
        return {
            data,
            del,
            insert,
            update,
            isLoading,
            genres,
            penulis
        }
    },
    data() {
        return {
            search: null,
            dialog: false,
            timeout: 1000,
            toInsert: true,
            itemContent: [],
            confirm: false,
            menu: false,
            headers: [
                {
                    text: "Judul",
                    align: "start",
                    sortable: true,
                    value: "judul",
                },
                { text: "Genre", value: "genre.nama" },
                { text: "Penulis", value: "penulis.nama" },
                { text: "Stok", value: "stok" },
                { text: "Penerbit", value: "penerbit" },
                { text: "Actions", value: "actions" },
                { text: '', value: 'data-table-expand' },
            ],
            formContent: {
                nama: null
            }
        };
    },
    methods: {
        cancel() {
            this.resetForm()
            this.dialog = false
            this.confirm = false
        },
        resetForm() {
            this.formContent = {
                nama: null
            };
        },
        setEditItem(){
            this.toInsert=false;
            this.formContent = {...this.itemContent}

        }
    }
}
</script>

<style>

</style>
