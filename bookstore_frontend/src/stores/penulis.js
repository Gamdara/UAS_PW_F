/* eslint-disable */
import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
import client from '@/api/request'

export const usePenulisStore = defineStore("penulis",{
    state: () => ({
        penulis: [],
    }),
    getters: {
        getPenulis(state){
            return state.penulis
        }
    },
    actions: {
        async get() {
            try {
                const res = await client().get('penulis')
                this.penulis = res.data.data
                return this.penulis
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async update(data) {
            try {
                const res = await client().post('penulis/'+data.id+'?_method=PUT',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async insert(data) {
            try {
                const res = await client().post('penulis',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async delete(id) {
            try {
                const res = await client().delete('penulis/'+id)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
    },
})