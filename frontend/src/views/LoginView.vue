  <template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" v-model="password" required />
        </div>
        <button type="submit">Login</button>
      </form>
      <button @click="goToRegister">Register</button>
    </div>
  </template>

  <script>
  export default {
    name: 'LoginView',
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async login() {
        try {
          const response = await fetch('http://localhost/PruebaTecnica/public/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email: this.email, password: this.password }),
          });

          if (!response.ok) {
            const data = await response.json();
            console.error('Error:', data);
            // Manejar el error de autenticación
            alert('Login failed: ' + data.error);
            return;
          }

          const data = await response.json();
          console.log(data);

          // Almacenar el usuario en el localStorage
          localStorage.setItem('user', JSON.stringify(data.user));

          // Redirigir al usuario a la página de inicio o a su dashboard
          this.$router.push('/index');
        } catch (error) {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
        }
      },
      goToRegister() {
        this.$router.push('/register');
      },
    },
  };
  console.log(localStorage.getItem('user'));

  </script>

  <style scoped>
  /* Estilos para el formulario de login */
  .login-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .login-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }

  .login-container form {
    display: flex;
    flex-direction: column;
  }

  .login-container form div {
    margin-bottom: 10px;
  }

  .login-container form label {
    font-weight: bold;
    color: #555;
  }

  .login-container form input[type="email"],
  .login-container form input[type="password"] {
    padding: 8px;
    border-radius: 3px;
    border: 1px solid #ccc;
  }

  .login-container form button {
    padding: 10px;
    border-radius: 3px;
    border: none;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .login-container form button:hover {
    background-color: #0056b3;
  }

  .login-container button {
    margin-top: 10px;
    padding: 5px 10px;
    border-radius: 3px;
    border: none;
    background-color: #f9f9f9;
    color: #007bff;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .login-container button:hover {
    background-color: #e9ecef;
  }
  </style>
