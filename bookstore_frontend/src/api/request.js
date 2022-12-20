/* eslint-disable */
import axios from "axios";

const client = () => axios.create({
  baseURL: 'https://frederikus.com/api_tubes_pw/public/api/',
  headers: {
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'Content-Type': 'multipart/form-data'
  }
});

export default client
