<template>
  <div>
    <v-card class="mt-4" id="card">
        <v-card-title>
            <v-list-item-title class="headline">Buku </v-list-item-title>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="data"
            :search="search"
            :expanded.sync="expanded"
            item-key="id"
            class="elevation-1"
            :loading="isLoading"
            loading-text="Loading..."
            show-expand
            id="content"
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
                        <v-btn fab small color="green" dark @click="exportToPDF"> <v-icon>mdi-file</v-icon> </v-btn>
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
                        <v-col cols="1">
                            <v-img
                            width="70px" height="100px"
                            contain
                            max-height="250"
                            :src="item.cover"
                            ></v-img>
                        </v-col>
                        <v-col cols="11">
                            <p class="mt-5 mb-0 font-weight-bold">Detail</p>
                            <v-row class="ms-2">
                            <v-col cols="6">
                                <p>Bahasa : {{ item?.bahasa }}</p>
                                <p>Jumlah Halaman : {{ item?.halaman }}</p>
                                <p>Genre : {{ item?.genre?.nama }}</p>
                            </v-col>
                            <v-col cols="6">
                                <p>Penulis : {{ item?.penulis?.nama }}</p>
                                <p>Penerbit : {{ item?.penerbit }}</p>
                                <p>Tanggal Terbit : {{ item?.tgl_terbit }}</p>
                            </v-col>
                            </v-row>
                        </v-col>
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
                    <v-text-field v-model="formContent.stok" label="stok" type="number" required></v-text-field>
                    <v-text-field v-model="formContent.harga" label="harga" required type="number"></v-text-field>
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
                            label="Tanggal terbit"
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
                    <v-file-input v-model="formContent.cover" label="cover" required></v-file-input>
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

<script setup>
/* eslint-disable */
import { onMounted, ref } from 'vue';
import { useGenreStore } from '@/stores/genre';
import { computed } from 'vue';
import { useBukuStore } from '@/stores/buku';
import { usePenulisStore } from '@/stores/penulis';

const store = useBukuStore()
const storeGenre = useGenreStore()
const storePenulis = usePenulisStore()
const validation = ref([])

const data = computed(() => store.buku);
const genres = computed(() => storeGenre.genre.map(x=> {return {text: x.nama, value: x.id}}));
const penulis = computed(() => storePenulis.penulis.map(x=> {return {text: x.nama, value: x.id}}));

const isLoading = ref(false)

onMounted(() => {
    fetchAll()
    storeGenre.get()
    storePenulis.get()
})

async function del(id) {
    isLoading.value = true
    let res = await store.delete(id) 
    validation.value = res.data && !res.data.status ? res.data.errors : {}
    isLoading.value = false
    fetchAll()
}

async function update(data) {
    isLoading.value = true
    let res = await store.update(data) 
    validation.value = res.data && !res.data.status ? res.data.errors : {}
    isLoading.value = false
    fetchAll()
}

async function fetchAll(){
    isLoading.value = true
    let res = await store.get() 
    validation.value = res.data && !res.data.status ? res.data.errors : {}
    isLoading.value = false
}

async function insert(data){
    isLoading.value = true
    let res = await store.insert(data) 
    validation.value = res.data && !res.data.status ? res.data.errors : {}
    isLoading.value = false
    fetchAll()
}



</script>
<script>
import html2pdf from "html2pdf.js";
    export default{
    data() {
        return {
            search: null,
            dialog: false,
            timeout: 1000,
            expanded: [],
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
                { text: "Harga", value: "harga" },
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

        },
        exportToPDF() {
            html2pdf(document.getElementById("card"), {
                margin: 4,
                filename: "Daftar Buku.pdf",
            });
        }
    }
}
</script>

<style>

</style>
