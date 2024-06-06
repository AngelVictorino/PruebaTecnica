<template>
  <div class="register-container">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div>
        <label for="name">Name</label>
        <input type="text" v-model="name" required />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Register</button>
    </form>
    <button @click="goToLogin">Login</button>
  </div>
</template>

<script>
export default {
  name: 'RegisterView',
  data() {
    return {
      name: '',
      email: '',
      password: '',
    };
  },
  methods: {
    async register() {
      try {
        const response = await fetch('http://localhost/PruebaTecnica/public/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ nombre: this.name, email: this.email, password: this.password }),
        });
        const data = await response.json();
        if (response.ok) {
          console.log(data);
          this.$router.push('/login');
        } else {
          console.error('Error:', data);
        }
      } catch (error) {
        console.error('Error:', error);
      }
    },
    goToLogin() {
      this.$router.push('/login');
    },
  },
};
</script>

<style scoped>
/* Estilos para el formulario */
.register-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.register-container h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333; /* Cambia el color del texto */
}

.register-container form {
  display: flex;
  flex-direction: column;
}

.register-container form div {
  margin-bottom: 10px;
}

.register-container form label {
  font-weight: bold;
  color: #555; /* Cambia el color del texto */
}

.register-container form input[type="text"],
.register-container form input[type="email"],
.register-container form input[type="password"] {
  padding: 8px; /* Aumenta el padding para que los inputs sean más altos */
  border-radius: 3px;
  border: 1px solid #ccc;
}

.register-container form button {
  padding: 10px;
  border-radius: 3px;
  border: none;
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
  transition: background-color 0.3s; /* Agrega transición al cambio de color */
}

.register-container form button:hover {
  background-color: #0056b3;
}

.register-container button {
  margin-top: 10px;
  padding: 5px 10px;
  border-radius: 3px;
  border: none;
  background-color: #f9f9f9;
  color: #007bff;
  cursor: pointer;
  transition: background-color 0.3s; /* Agrega transición al cambio de color */
}

.register-container button:hover {
  background-color: #e9ecef;
}
</style>
