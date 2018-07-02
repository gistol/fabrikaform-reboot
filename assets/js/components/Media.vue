<template>
  <div>
    <div>
      Media.vue
    </div>
    <router-link :to="{ name: 'Intro' }">Intro</router-link>
    <router-link :to="{ name: 'Menu' }">Menu</router-link>

    <div>
      {{ media }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Media',
  data() {
    return {
      media: {}
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      axios
        .get(`/media/${this.$route.params.id}`)
        .then(response => {
          // JSON responses are automatically parsed.
          this.media = response.data;
        })
        .catch(e => {
          console.error(e);
        });
    }
  }
};
</script>

<style lang="scss">
.body {
  background-color: salmon;
}
</style>
