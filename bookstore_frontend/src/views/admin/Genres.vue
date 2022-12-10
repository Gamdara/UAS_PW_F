<template>
  <div>
    <v-card>
        <v-card-title>
            <v-list-item-title class="headline">Genres </v-list-item-title>
        </v-card-title>
    </v-card>
    <v-card class="mt-4">
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
                    </v-col>
                </v-row>
            </template>
            <template v-slot:[`item.actions`]="{ item }">
                <v-btn
                    class="ma-2"
                    fab
                    small
                    color="error"
                    @click="
                    dialog = true;
                    itemContent = item;
                    setEditItem()
                        "><v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn
                    class="ma-2"
                    fab
                    small
                    color="success"
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
            class="headline">{{toInsert ? 'Tambah Genre' : 'Edit Genre'}}</v-toolbar>
            <v-card-text>
                <v-container>
                    <v-text-field
                    v-model="formContent.nama"
                    label="Name"
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

<script>
/* eslint-disable */
import client from '@/api/request';
import { onMounted, reactive, ref } from 'vue';
export default {
    name: 'AdminGenre',
    setup() {
        const data = ref([])
        const validation = ref([])
        const isLoading = ref(false)
        //mounted
        onMounted(() => {
            fetchAll()
        })

        function del(id) {
            isLoading.value = true
            client.delete('genres/'+id)
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
            client.put('genres/'+data.id,data)
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
            client.get('genres')
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
            client.post('genres',data)
            .then(response => {
                isLoading.value = false
                alert("Berhasil insert")
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
            isLoading
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
            headers: [
                {
                    text: "Name",
                    align: "start",
                    sortable: true,
                    value: "nama",
                },
                { text: "Actions", value: "actions" },
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
