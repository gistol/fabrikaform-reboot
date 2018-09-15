<template>
  <div class="pos-r">
    <router-link :to="{ name: 'Intro' }">Intro</router-link>
    <router-link :to="{ name: 'Menu' }">Menu</router-link>

    <div>
      {{ media }}
    </div>
    <router-link v-if="media.navigation.previous" :to="{ name: 'Media', params: {'id': media.navigation.previous} }">&lt;</router-link>
    <router-link v-if="media.navigation.next" :to="{ name: 'Media', params: {'id': media.navigation.next} }">&gt;</router-link>
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
  },
  watch: {
    $route() {
      this.fetchData();
    }
  }
};
</script>

<style lang="scss">
.body {
  background-color: salmon;
}
</style>
