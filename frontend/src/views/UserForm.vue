<template>
    <div>
      <h1>{{ isEditMode ? 'Edit User' : 'Create User' }}</h1>
      <form @submit.prevent="submitForm">
        <div>
          <label for="name">Name:</label>
          <input type="text" v-model="user.name" required />
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" v-model="user.email" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" v-model="user.password" :required="!isEditMode" />
        </div>
        <button type="submit">{{ isEditMode ? 'Update' : 'Create' }}</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'UserForm',
    data() {
      return {
        user: {
          name: '',
          email: '',
          password: ''
        },
        isEditMode: false
      };
    },
    created() {
      if (this.$route.params.id) {
        this.isEditMode = true;
        this.loadUser(this.$route.params.id);
      }
    },
    methods: {
      loadUser(userId) {
        axios.get(`/users/${userId}`)
          .then(response => {
            this.user = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
      submitForm() {
        if (this.isEditMode) {
          axios.put(`/users/${this.$route.params.id}`, this.user)
            .then(() => {
              this.$router.push('/users');
            })
            .catch(error => {
              console.error(error);
            });
        } else {
          axios.post('/users', this.user)
            .then(() => {
              this.$router.push('/users');
            })
            .catch(error => {
              console.error(error);
            });
        }
      }
    }
  };
  </script>
  