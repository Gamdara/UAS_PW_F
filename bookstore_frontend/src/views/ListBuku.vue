<template>
    <div>
      <div class="container">
        <div class="row mt-4">
          <div class="col">
            <h2>
              List
              <strong>Buku</strong>
            </h2>
          </div>
        </div>
  
        <div class="row mt-3">
          <div class="col">
            <div class="input-group mb-3">
              
              <input
                v-model="search"
                type="text"
                class="form-control"
                placeholder="Cari Buku Kesukaan Anda .."
                aria-label="Cari"
                aria-describedby="basic-addon1"
                @keyup="searchBook"
              />
  
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                  <b-icon-search></b-icon-search>
                </span>
              </div>
            </div>
          </div>
        </div>
  
        <div class="row mb-4">
          <div class="col-md-4 mt-4" v-for="product in products" :key="product.id">
            <CardProduct :product="product" />
          </div>
        </div>
      </div>
    </div>
  </template>

<script>
import axios from 'axios'
import CardProduct from "@/components/CardProduct.vue";

export default {
    name: 'ListBuku',
    components: {
        CardProduct,
    },

    data() {
        return {
            products: [],
            search: '',
        };
    },
    
    methods: {
        setProducts(data) {
            this.products = data;
        },
        searchBook() {
            axios.get('http://127.0.0.1:8000/api/' + this.search)
            .then((response) => this.setProducts(response.data))
            .catch((error) => console.log(error));
        }
    },
    mounted() {
    axios
      .get('http://127.0.0.1:8000/api/')
      .then((response) => this.setProducts(response.data))
      .catch((error) => console.log(error));
  },
};
</script>
<style>
</style>