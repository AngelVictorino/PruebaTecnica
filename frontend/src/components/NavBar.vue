<template>
  <nav>
    <div class="nav-brand">Inicio</div>
    <div class="nav-items">
      <a href="#" class="nav-item">Videos</a>
      <a href="#" class="nav-item">Videos favoritos</a>
      <a href="#" class="nav-item">Contacto</a>
    </div>
    <div class="nav-items-right">
      <div class="nav-dropdown" @click="toggleDropdown">
        <button class="btn dropdown-btn">Usuario</button>
        <div v-if="isDropdownOpen" class="dropdown-content">
          <p>{{ currentUser.name }}</p>
          <p>{{ currentUser.email }}</p>
          <a href="#">Perfil</a>
          <a href="#">Cerrar Sesión</a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'NavBar',
  data() {
    return {
      isDropdownOpen: false,
      currentUser: {
        name: 'John Doe',
        email: 'john.doe@example.com'
      }
    };
  },
  methods: {
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    }
  }
};
</script>

<style scoped>
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #333;
  color: white;
  padding: 0.5rem 1rem;
}

.nav-brand {
  font-weight: bold;
}

.nav-items {
  display: flex;
}

.nav-item {
  margin-right: 1rem;
  color: white;
  text-decoration: none;
}

.nav-items-right {
  display: flex;
}

.nav-form {
  margin-right: 1rem;
  display: flex;
}

.form-input {
  padding: 0.25rem;
  margin-right: 0.5rem;
}

.btn {
  padding: 0.25rem 0.5rem;
  background-color: #555;
  color: white;
  border: none;
  cursor: pointer;
}

.nav-dropdown {
  position: relative;
  margin-right: 1rem;
}

.dropdown-btn {
  padding: 0.25rem 0.5rem;
  background-color: #555;
  color: white;
  border: none;
  cursor: pointer;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #333;
  min-width: 100px;
  z-index: 1;
}

.dropdown-content a {
  display: block;
  padding: 0.25rem 1rem;
  text-decoration: none;
  color: white;
}

.dropdown-content a:hover {
  background-color: #555;
}

.nav-dropdown:hover .dropdown-content {
  display: block;
}
</style>
