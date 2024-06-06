<template>
  <div>
    <h1>Home</h1>
    <input v-model="searchQuery" @input="searchVideos" placeholder="Search for videos" />
    <ul>
      <li v-for="video in videos" :key="video.id">
        {{ video.title }}
        <button @click="addToFavorites(video)">Add to Favorites</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HomePage',  // Renombrar el componente a HomePage
  data() {
    return {
      searchQuery: '',
      videos: []
    };
  },
  methods: {
    searchVideos() {
      axios.get(`https://www.googleapis.com/youtube/v3/search?q=${this.searchQuery}&key=TU_API_KEY`)
        .then(response => {
          this.videos = response.data.items;
        })
        .catch(error => {
          console.error(error);
        });
    },
    addToFavorites(video) {
      axios.post('/favorites', video)
        .then(response => {
          console.log(response.data.message);
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
};
</script>
