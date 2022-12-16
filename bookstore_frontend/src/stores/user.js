/* eslint-disable */
import { defineStore } from 'pinia'
// Import axios to make HTTP requests
import axios from "axios"
import client from '@/api/request'

export const useUserStore = defineStore("user",{
    state: () => ({
        user: {},
        token: localStorage.getItem('token') || null
    }),
    getters: {
        getToken(state){
            return state.token
        },
        getUser(state){
            return state.user
        }
    },
    actions: {
        async login(params) {
            try {
                const res = await axios.post('http://127.0.0.1:8000/api/' + "login", params, {
                    headers: {'Content-Type': 'application/json'}
                })
                this.token = res.data.token
                this.user = res.data.data
                localStorage.setItem('token',this.token)
                this.$router.push('/')
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async profile(){
            if(!this.token) return
            try {
                const data = await client().get('profile')
                this.user = data.data.data
                return data.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async update(data){
            try {
                const data = await client().post('profile',data)
                this.user = data.data.data
                return data.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        },
        async logout() {
            try {
                const data = await client().get('logout')
                localStorage.removeItem('token')
                this.$router.push('/login')
                return data.data
            }
            catch (error) {
                console.log(error)
                return error.response
            }
        }
    },
})