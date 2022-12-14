/* eslint-disable */
import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
import client from '@/api/request'

export const useGenreStore = defineStore("genre",{
    state: () => ({
        genre: [],
    }),
    getters: {
        getGenre(state){
            return state.genre
        }
    },
    actions: {
        async get() {
            try {
                const res = await client().get('genre')
                this.genre = res.data.data
                return this.genre
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async update(data) {
            try {
                const res = await client().post('genre/'+data.id+'?_method=PUT',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async insert(data) {
            try {
                const res = await client().post('genre',data)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async delete(id) {
            try {
                const res = await client().delete('genre/'+id)
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
    },
})