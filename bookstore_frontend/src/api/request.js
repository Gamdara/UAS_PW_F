/* eslint-disable */
import axios from "axios";

const client = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/',
  headers: {
    'Accept': 'application/json',
    'Authorization': `Bearer ${localStorage.getItem('token')}`,
    'Content-Type': 'multipart/form-data'
  }
});

export default client
