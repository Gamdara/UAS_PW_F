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
                const res = await axios.post('https://frederikus.com/api_tubes_pw/public/api/' + "login", params, {
                    headers: {'Content-Type': 'application/json'}
                })
                this.token = res.data.token
                this.user = res.data.data
                localStorage.setItem('token',this.token)
                if(this.user.role=='admin')
                this.$router.push('/admin')
                else
                this.$router.push('/')
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response.data
            }
        },
        async register(params) {
            try {
                const res = await axios.post('https://frederikus.com/api_tubes_pw/public/api/' + "register", params, {
                    headers: {'Content-Type': 'application/json', 'Content-Type': 'multipart/form-data'},
                })
                this.$router.push('/login')
                return res.data
            }
            catch (error) {
                console.log(error)
                return error.response.data
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
                return error.response.data
            }
        },
        async update(user){
            try {
                const data = await client().post('profile',user)
                this.user = data.data.data
                return data.data
            }
            catch (error) {
                console.log(error)
                return error.response.data
            }
        },
        async logout() {
            try {
                const data = await client().get('logout')
                localStorage.removeItem('token')
                this.$router.push('/login')
                this.user = {}
                this.token = null
                return data.data
            }
            catch (error) {
                console.log(error)
                return error.response.data
            }
        }
    },
})