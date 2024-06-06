<template>
  <div>
    <h1>Favorites</h1>
    <ul>
      <li v-for="video in favorites" :key="video.id">
        {{ video.title }}
        <button @click="removeFromFavorites(video.id)">Remove from Favorites</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'FavoritesPage',  // Renombrar el componente a FavoritesPage
  data() {
    return {
      favorites: []
    };
  },
  created() {
    this.loadFavorites();
  },
  methods: {
    loadFavorites() {
      axios.get('/favorites')
        .then(response => {
          this.favorites = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    removeFromFavorites(videoId) {
      axios.delete(`/favorites/${videoId}`)
        .then(() => {
          this.loadFavorites();
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>
