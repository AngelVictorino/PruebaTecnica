<template>
    <aside class="left-bar">
      <h2>Menu</h2>
      <ul>
        <li><a href="#">Opción 1</a></li>
        <li><a href="#">Opción 2</a></li>
        <li><a href="#">Opción 3</a></li>
      </ul>
    </aside>
  </template>
  
  <script>
  export default {
    name: 'LeftBar',
    // Lógica del componente aquí
  };
  </script>
  
  <style scoped>
  .left-bar {
    width: 200px;
    background-color: #f4f4f4;
    padding: 20px;
    border-right: 1px solid #ddd;
  }
  
  .left-bar h2 {
    margin-bottom: 10px;
    font-size: 1.2rem;
  }
  
  .left-bar ul {
    list-style-type: none;
    padding: 0;
  }
  
  .left-bar li {
    margin-bottom: 10px;
  }
  
  .left-bar a {
    text-decoration: none;
    color: #333;
  }
  
  .left-bar a:hover {
    color: #007bff;
  }
  </style>
  