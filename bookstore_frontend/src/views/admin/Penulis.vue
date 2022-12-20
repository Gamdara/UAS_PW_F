<template>
  <div>
    <v-card class="mt-4" id="card">
        <v-card-title>
            <v-list-item-title class="headline">Penulis </v-list-item-title>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="data"
            :search="search"
            item-key="name"
            class="elevation-1"
            :loading="isLoading"
            loading-text="Loading..."
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
                <!-- tambahkan dialog untuk konfirmasi delete agar bisa delete data -->
                </v-btn>
            </template>
        </v-data-table>
    </v-card>
    <v-dialog transition="dialog-top-transition" v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-toolbar
            color="brown darken-1"
            dark
            class="headline">{{toInsert ? 'Tambah penulis' : 'Edit penulis'}}</v-toolbar>
            <v-card-text>
                <v-container>
                    <v-text-field
                    v-model="formContent.nama"
                    label="Name"
                    required
                    ></v-text-field>
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
                            v-model="formContent.tgl_lahir"
                            label="Tanggal lahir"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                        ></v-text-field>
                        </template>
                        <v-date-picker
                        v-model="formContent.tgl_lahir"
                        @input="menu = false"
                        ></v-date-picker>
                    </v-menu>
                    <v-text-field
                    v-model="formContent.asal"
                    label="Asal"
                    required
                    ></v-text-field>
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
import { usePenulisStore } from '@/stores/penulis';
import { computed } from 'vue';

const store = usePenulisStore()
const validation = ref([])

const data = computed(() => store.penulis);
const isLoading = ref(false)

onMounted(() => {
    fetchAll()
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
            toInsert: true,
            itemContent: [],
            menu: false,
            confirm: false,
            headers: [
                {
                    text: "Name",
                    align: "start",
                    sortable: true,
                    value: "nama",
                },
                { text: "Tanggal Lahir", value: "tgl_lahir" },
                { text: "Asal", value: "asal" },
                { text: "Actions", value: "actions" },
            ],
            formContent: {
                nama: null,
                tgl_lahir: null,
                asal: null
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
                nama: null,
                tgl_lahir: null,
                asal: null
            };
        },
        setEditItem(){
            this.toInsert=false;
            this.formContent = {...this.itemContent}
        },
        exportToPDF() {
            html2pdf(document.getElementById("card"), {
                margin: 4,
                filename: "Daftar Penulis.pdf",
            });
        }
    }
}
</script>

<style>

</style>
