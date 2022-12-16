/* eslint-disable */
import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
import client from '@/api/request'

export const useTransaksiStore = defineStore("transaksi",{
    state: () => ({
        transaksi: [],
    }),
    getters: {
        gettransaksi(state){
            return state.transaksi
        }
    },
    actions: {
        async get() {
            try {
                const res = await client().get('transaksi')
                this.transaksi = res.data.data
                return this.transaksi
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async update(data) {
            try {
                const res = await client().post('transaksi/'+data.id+'?_method=PUT',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async insert(data) {
            try {
                const res = await client().post('transaksi',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async delete(id) {
            try {
                const res = await client().delete('transaksi/'+id)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
    },
})