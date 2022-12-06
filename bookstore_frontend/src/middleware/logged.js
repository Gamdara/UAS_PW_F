/* eslint-disable */
export default function logged ( to,from,next ) {
    if (localStorage.getItem('token')) 
      next({ name: 'Home' })
    next()
}
