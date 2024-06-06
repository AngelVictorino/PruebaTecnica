<template>
    <div>
      <h1>Users</h1>
      <ul>
        <li v-for="user in users" :key="user.id">
          {{ user.name }} - {{ user.email }}
          <button @click="editUser(user.id)">Edit</button>
          <button @click="deleteUser(user.id)">Delete</button>
        </li>
      </ul>
      <button @click="createUser">Create User</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'UserList',
    data() {
      return {
        users: []
      };
    },
    created() {
      this.loadUsers();
    },
    methods: {
      loadUsers() {
        axios.get('/users')
          .then(response => {
            this.users = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
      createUser() {
        this.$router.push('/users/create');
      },
      editUser(userId) {
        this.$router.push(`/users/edit/${userId}`);
      },
      deleteUser(userId) {
        axios.delete(`/users/${userId}`)
          .then(() => {
            this.loadUsers();
          })
          .catch(error => {
            console.error(error);
          });
      }
    }
  };
  </script>
  