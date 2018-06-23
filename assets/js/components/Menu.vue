<template>
  <div>
    Menu.vue
    <router-link :to="{ name: 'Intro' }">Intro</router-link>
    <router-link :to="{ name: 'Media' }">Media</router-link>
  </div>
</template>

<script>
export default {
  name: 'Menu',
  mounted() {}
};
</script>
