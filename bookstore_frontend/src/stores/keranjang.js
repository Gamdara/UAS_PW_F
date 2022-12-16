/* eslint-disable */
import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
import client from '@/api/request'

export const useKeranjangStore = defineStore("keranjang",{
    state: () => ({
        keranjang: [],
    }),
    getters: {
        getkeranjang(state){
            return state.keranjang
        }
    },
    actions: {
        async get() {
            try {
                const res = await client().get('keranjang')
                this.keranjang = res.data.data
                return this.keranjang
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async insert(data) {
            try {
                const res = await client().post('keranjang',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async delete(id) {
            try {
                const res = await client().delete('keranjang/'+id)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
    },
})