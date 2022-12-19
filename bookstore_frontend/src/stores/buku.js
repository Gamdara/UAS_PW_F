/* eslint-disable */
import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
import client from '@/api/request'

export const useBukuStore = defineStore("buku",{
    state: () => ({
        buku: [],
        selected: {}
    }),
    getters: {
        getBuku(state){
            return state.buku
        }
    },
    actions: {
        async get() {
            try {
                const res = await axios.get(client().defaults.baseURL+'bukus')
                this.buku = res.data.data
                return this.buku
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async getById(id) {
            try {
                const res = await axios.get(client().defaults.baseURL+'bukus/'+id)
                this.selected = res.data.data
                return res.data.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async update(data) {
            try {
                const res = await client().post('buku/'+data.id+'?_method=PUT',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async insert(data) {
            try {
                const res = await client().post('buku',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async addReview(data) {
            try {
                const res = await client().post('review',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async delete(id) {
            try {
                const res = await client().delete('buku/'+id)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
    },
})