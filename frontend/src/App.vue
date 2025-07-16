<template>
   <div>
     <h1>CRUD APPLICATION</h1>
     <form @submit.prevent="createItem">
        <input v-model="form.name" placeholder="Enter name" />
        <input v-model.number="form.qty" placeholder="Enter quantity" />
        <input v-model.number="form.price" placeholder="Enter price" />
        <button type="submit">Add Item</button>
     </form>
     <table>
       <thead>
         <tr>
          <th>Name</th>
          <th>Quantity</th>
          <th>Price</th>
         </tr>
       </thead>
       <tbody v-for="item in items" :key="items.id">
         <tr>
           <td>{{item.name}}</td>
           <td>{{item.qty}}</td>
           <td>P{{item.price}}</td>
         </tr>
         
       </tbody>
     </table>
   </div>
</template>

<script setup>
import axios from 'axios';
import {ref, onMounted} from "vue";

const form = ref({
    name: "",
    qty: 0,
    price: 0.0
});

const items = ref([]);

const fetchItems = () => {
    axios.get("/items").then(res => {
    items.value = res.data;
    })
}

const createItem = () => {
   axios.post("/items", form.value).then(() => {
     form.value = {name: "", qty: 0, price: 0.0};
     fetchItems();
   })
}

onMounted(() => {
   fetchItems();
})

</script>

<style scoped>
</style>
