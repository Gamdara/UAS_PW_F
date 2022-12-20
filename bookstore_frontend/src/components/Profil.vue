<template>
    <div>
        <v-container fluid fill-height class="posisinya mt-15">
            <v-row align="center" justify="center" >
                <v-form ref="form" >
                    <v-row>
                        <v-col>
                            <v-card class="mt-6" width="500px" min-height="300px">
                                <v-row align="center" justify="center" class="mt-n5">
                                    <v-card append color="success" width="450px" height="50px">
                                        <v-card-title class="cardTitle pa-0 my-2 justify-center"> {{ cardtitle }} </v-card-title>
                                    </v-card>
                                </v-row>
                                <v-row>
                                    <v-col class="mt-3 ml-8 mr-4 mb-3" cols="3">
                                        <v-avatar size="120">
                                            <v-img  :src="preview_foto ? preview_foto : user.foto ? user.foto : '@/assets/logo.png'"></v-img>
                                        </v-avatar>
                                        <v-btn v-if="btnEdit == true" x-small @click="$refs.fileInput.click()" class="iconedit ml-15 mt-n8" fab dark color="error">
                                            <v-icon dark>mdi-image-edit</v-icon>
                                        </v-btn>
                                        <input v-if="btnEdit == true" type="file" style="display: none" @change="upload" ref="fileInput">
                                    </v-col>
                                </v-row>
                                <v-divider class="mx-4 bold"></v-divider>
                                <v-row class="my-2 mx-5">
                                    <v-col cols="12" sm="12">
                                        <v-text-field class="formtxt" v-model="user.nama" label="Name" :error-messages="errors.nama" :readonly="btnEdit == false"></v-text-field>
                                        <v-text-field class="formtxt" v-model="user.username" label="Username" :error-messages="errors.username" :readonly="btnEdit == false"></v-text-field>
                                        <v-text-field class="formtxt" v-model="user.email" label="Email" :error-messages="errors.email" :readonly="btnEdit == false"></v-text-field>
                                        <v-text-field class="formtxt"  v-model="user.no_hp" label="No Hp" :error-messages="errors.no_hp" :readonly="btnEdit == false"></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row v-if="btnEdit == true" class="mx-8 mt-n6 mb-3">
                                    <v-checkbox v-model="enabled" hide-details class="shrink" ></v-checkbox>
                                    <v-text-field v-model="newPassword" class="formtxt"  :disabled="!enabled" :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'" :type="show ? 'text' : 'password'" @click:append="show = !show" label="Password baru" placeholder="New Password"></v-text-field>
                                </v-row>
                                <v-col class="mt-5 ml-10" cols="3">
                                        <v-row>
                                            <v-btn class="my-10" v-if="btnEdit == false" @click.stop="btnEdit = !btnEdit" rounded outlined color="danger">
                                                <v-icon>mdi-pencil</v-icon>
                                            </v-btn>
                                        </v-row>
                                        <v-row>
                                            <v-btn class="my-5" v-if="btnEdit == true" @click="save" rounded outlined color="success">
                                                <v-icon>mdi-check-bold</v-icon>
                                            </v-btn>
                                            <v-btn class="my-5" v-if="btnEdit == true" @click="cancel" rounded outlined color="error">
                                                <v-icon>mdi-close-thick</v-icon>
                                            </v-btn>
                                        </v-row>
                                    </v-col>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-form>
            </v-row>
        </v-container>
        <!-- <v-snackbar v-model="snackbar" color="red" timeout="2000" bottom>{{ error_message }}</v-snackbar> -->
    </div>
</template>
<style>
    .cardTitle{
        font-family: Akshar;
        font-size: 30px;
        color: yellow;
    }
</style>
<script setup>
/* eslint-disable */
    import { computed, onMounted, ref } from 'vue';
    import { useUserStore } from '../stores/user';
    const errors = ref({})
    const enabled =  ref(false)
    const preview_foto =  ref()
    const show = ref(false)
    const snackbar = ref(false)
    const btnEdit = ref(false)
    const url_foto = ref(null)
    const editdata = ref({})
    const newPassword = ref(null)
    const store = useUserStore()
    const user = computed(() => store.user)

    async function save() {
        let res = await store.update(store.user)
        console.log(res);
        if(!res.status){
            errors.value = res.errors || {}
        }
        else{
            errors.value = {}
            await store.profile()
            btnEdit.value = false;
        }
    }
    async function cancel(){
        await store.profile()
        btnEdit.value = false;
        preview_foto.value = null
    }
    function upload(event) {
        let url = event.target.files[0];
        user.value.foto = url
        preview_foto.value = URL.createObjectURL(url);
    }

    const cardtitle = computed(()=> {
        return btnEdit.value === false ? 'Profil' : 'Edit Profil'
    })

    onMounted(async () => {
        await store.profile()
        console.log(store.user);
    })
</script>
