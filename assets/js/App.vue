<template>
  <div id="app">
    <div class="background" v-bind:class="{ loaded: isLoaded }"></div>
    <div v-if="!isLoaded">loader</div>
    <template v-else>
      <router-view></router-view>
    </template>
  </div>
</template>

<script>
import { preloadImg } from './Tools';
import backgroundURL from '../img/background.jpg';

export default {
  name: 'app',
  data() {
    return {
      isLoaded: false
    };
  },
  async beforeCreate() {
    // preload common assets
    let start = new Date().getTime();
    preloadImg(backgroundURL).then(() => {
      let duration = new Date().getTime() - start;
      // Set minimum loading time to 1 sec
      if (duration < 1000) {
        setTimeout(() => {
          this.isLoaded = true;
        }, 1000 - duration);
      } else {
        this.isLoaded = true;
      }
    });
  }
};
</script>

<style lang="scss">
body,
html {
  margin: 0;
  height: 100%;
}

#app > * {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.background {
  opacity: 0;
  transition: opacity 300ms ease;

  &.loaded {
    background: url('../img/background.jpg');
    opacity: 1;
  }
}

// Transitions
.fade-enter-active {
  transition: opacity 0.25s ease-in;
}
.fade-leave-active {
  transition: opacity 0.25s ease-out;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
