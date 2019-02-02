<template>
  <div id="app">
    <div class="background" v-bind:class="{ loaded: isLoaded }"></div>

    <transition
      appear
      enter-class="fade-enter"
      enter-to-class="fade-enter-to"
      enter-active-class="fade-delay-enter-active"
    >
      <div>
        <Logo v-bind:isAppLoaded="isLoaded"></Logo>
      </div>
    </transition>

    <template v-if="isLoaded">
      <router-view class="main"></router-view>
    </template>
  </div>
</template>

<script>
import { preloadImg } from "./Tools";
import backgroundURL from "../img/background.jpg";
import Logo from "./components/Logo.vue";

export default {
  name: "app",
  components: {
    Logo
  },

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
      // For transition and animation purpose,
      // set minimum loading time to 2 sec.
      if (duration < 4000) {
        setTimeout(() => {
          this.isLoaded = true;
          this.$store.commit("setLoadingState", false);
        }, 4000 - duration);
      } else {
        this.isLoaded = true;
        this.$store.commit("setLoadingState", false);
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

.background,
.background:after,
.main {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}

.background {
  &:after {
    content: "";
    display: block;
    opacity: 0;
    transition: opacity 800ms ease;
  }

  &.loaded:after {
    background: url("../img/background.jpg");
    opacity: 1;
  }
}

// Transitions
.fade-enter-active {
  transition: opacity 0.25s ease-in;
}

.fade-delay-enter-active {
  transition: opacity 0.5s ease-in 0.8s;
}

.fade-leave-active {
  transition: opacity 0.25s ease-out;
}

.fade-enter-to,
.fade-leave {
  opacity: 1;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
