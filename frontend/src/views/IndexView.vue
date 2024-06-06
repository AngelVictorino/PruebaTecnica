<template>
  <div class="container">
    
    <div class="content">
      <NavBar />
      <main>
        <h1>Bienvenido!</h1>
        <p>Hola Mundo.</p>
      </main>
    </div>
  </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';

export default {
  name: 'IndexView',
  components: {
    NavBar,
  },
  data() {
    return {
      leftBarVisible: true,
    };
  },
  methods: {
    toggleLeftBar() {
      this.leftBarVisible = !this.leftBarVisible;
    },
  },
};
</script>

<style scoped>
.container {
  display: flex;
}

.toggle-btn {
  position: absolute;
  top: 20px;
  right: 20px;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
}

.content {
  flex: 1;
  padding: 20px;
  background-color: #f9f9f9;
}

.nav-bar {
  background-color: #007bff;
  color: #fff;
  padding: 10px 20px;
}

.nav-bar ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
  display: flex;
}

.nav-bar li {
  margin-right: 20px;
}

.nav-bar a {
  text-decoration: none;
  color: #fff;
}

.nav-bar a:hover {
  text-decoration: underline;
}
</style>
