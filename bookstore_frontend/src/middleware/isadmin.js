/* eslint-disable */
import client from "@/api/request"

export default function isadmin ( to,from,next ) {
  if (!localStorage.getItem('token')) 
      next({ name: 'login' })
  client().get('profile').then(res => {
    if (!res.data.status || res.data.data.role != 'admin') 
      next({ name: 'Home' })
    next()
  })
}
