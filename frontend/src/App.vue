<template>
   <div>
     <h1>CRUD APPLICATION</h1>
     <form @submit.prevent="isEditing ? updateItem() : createItem()">
        <input v-model="form.name" placeholder="Enter name" />
        <input v-model.number="form.qty" placeholder="Enter quantity" />
        <input v-model.number="form.price" placeholder="Enter price" />
        <button id="submitBtn" type="submit">{{ isEditing ? "Update" : "Add Item" }}</button>
        <button v-if="isEditing" @click="cancelEdit()">Cancel</button>
     </form>
     <table>
       <thead>
         <tr>
          <th>Name</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Actions</th>
         </tr>
       </thead>
       <tbody v-for="item in items" :key="item.id">
         <tr>
           <td>{{item.name}}</td>
           <td>{{item.qty}}</td>
           <td>P{{item.price}}</td>
           <td><button @click="editItem(item)">Edit</button>
           <button @click="deleteItem(item.id)">Delete</button></td>
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
const isEditing = ref(false);
const editId = ref(null);

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

const editItem = (item) => {
  form.value = {...item};
  editId.value = item.id;
  isEditing.value = true;
}

const cancelEdit = () => {
  form.value = {name: "", qty: 0, price: 0.0}
  editId.value = null;
  isEditing.value = false;
}

const updateItem = () => {
  axios.put(`/items/${editId.value}`, form.value).then(() => {
     form.value = {name: "", qty: 0, price: 0.0};
     editId.value = null;
     isEditing.value = false;
     fetchItems();
  })
}

const deleteItem = (id) => {
    if(confirm("Are you sure you want to delete this item?")) {
        axios.delete(`/items/${id}`).then(() => {
          fetchItems();
        })
    }
}

onMounted(() => {
   fetchItems();
})

</script>

<style scoped>

table {
  width: 100%;
}

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  margin-top: 20px;
  padding: 10px;
  text-align: center;
}

#submitBtn {
  margin-left: 20px;
}

button {
  background-color: blue;
  color: white;
  border: none;
  border-radius: 10px;
  padding: 10px;
}

</style>
