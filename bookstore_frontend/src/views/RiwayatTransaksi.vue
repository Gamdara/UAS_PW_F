<template>
    <v-container fluid>
    <div class="list">
        <v-card class="mt-4" id="card">
        <v-card-title>
            <v-list-item-title class="headline">Transaksi </v-list-item-title>
        </v-card-title>
        <v-data-table
            id="content"
            :headers="headers"
            :items="data"
            :search="search"
            :expanded.sync="expanded"
            item-key="id"
            class="elevation-1"
            show-expand
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
                </v-row>
            </template>
            <template v-slot:expanded-item="{ headers,item }">
            <td :colspan="headers.length">
                <!-- {{ item.details }} -->
                <v-list nav dense>
                    <template>
                        <div v-for="(detail, i) in item.details" :key="i">
                            <v-list-item >
                                <v-list-item-avatar class="ms-2" style="border-radius:0px" width="70px" height="100px">
                                    <v-img :src="detail.bukus.cover"></v-img>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                <v-list-item-subtitle>Judul : {{ detail.bukus.judul }}</v-list-item-subtitle>
                                <v-list-item-title > Subtotal : {{ detail.subtotal  }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider class="m-0"></v-divider>
                        </div>
                    </template>
                </v-list>
            </td></template>
        </v-data-table>
    </v-card>
    </div>
</v-container>
</template>
<script setup>
/* eslint-disable */
import { onMounted, ref } from 'vue';
import { useGenreStore } from '@/stores/genre';
import { computed } from 'vue';
import { useTransaksiStore } from '@/stores/transaksi';

const store = useTransaksiStore()
const validation = ref([])

const data = computed(() => store.transaksi);
const isLoading = ref(false)

async function fetchAll(){
    isLoading.value = true
    let res = await store.get() 
    validation.value = res.data && !res.data.status ? res.data.errors : {}
    isLoading.value = false
}

onMounted(() => {
    fetchAll()
})
</script>
<script>
/* eslint-disable */
  export default {
    name: "ListBuku",
    data() { 
        return {
            expanded: [],
            load: false,
            url: null,
            image: null,
            snackbar: false,
            error_message: '',
            color: '',
            search: null, 
            dialog: false, 
            headers: [
                { text: "Tanggal",sortable: true, value: "tanggal" },
                { text: "Total", value: "total"},
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
    
  };
</script>