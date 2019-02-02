<template>
  <div class="wrapper" v-bind:class="{
      'js-app-loaded': isAppLoaded
    }">
    <svg
      class="logo"
      v-bind:class="{
        'js-loading': isAnimated,
      }"
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 291.2 165.54"
    >
      <title>Fabrikaform logo {{ isLoading.toString() }}</title>
      <path
        class="path stroke-black"
        d="M278.7,129.92s-20.42-10.42-43.22-10.42c-46.82,0-87.17,30-108,30-4.87,0-7-1.44-7-4,0-33.83,156-92.33,156-123,0-6.42-4-10-12-10-6.08,0-13.56,4.09-13.56,4.09"
      ></path>
      <line class="stroke-background" x1="68.43" y1="121.67" x2="12.5" y2="153.04"></line>
      <line class="stroke-black" x1="68.43" y1="121.67" x2="12.5" y2="153.04"></line>
      <path
        d="M76.05,107.1l10.71-6.16,1.42,2.47-7.63,4.39,1.79,3.11,7.18-4.13,1.38,2.39-7.18,4.13,3.06,5.32L83.7,120.4Z"
      ></path>
      <path
        d="M98.62,108.48l.65,3-3.08,1.77L93.59,97,97,95.07l12.78,10.34-3.08,1.77-2.24-2Zm3.81-5.07L96.55,98.2l0,0,1.55,7.7Z"
      ></path>
      <path
        d="M104.92,90.5l5.64-3.25a5.8,5.8,0,0,1,3.5-1.08A3.37,3.37,0,0,1,116.5,88a3.13,3.13,0,0,1-.19,3.88l0,0a3.63,3.63,0,0,1,4.87,1.7c1.31,2.28.75,4.83-2.82,6.88l-5.81,3.34ZM111,94.23l1.77-1c1.52-.87,1.86-1.65,1.17-2.85s-1.53-1.29-3-.42l-1.77,1Zm3.28,5.7,2.53-1.45c1.8-1,2-2.13,1.4-3.23s-1.69-1.45-3.5-.41l-2.53,1.45Z"
      ></path>
      <path
        d="M119.7,82,126,78.37c3.19-1.84,5.76-1.24,7.09,1.08,1.18,2.05.82,4.58-1.94,6.38l8.69,2.28-4.06,2.34L127.49,88l-.19.11,3.12,5.43-3.08,1.77Zm6.46,4.12,2.24-1.29c1.79-1,2.44-2.17,1.68-3.49a2,2,0,0,0-2.92-.6l-3.08,1.77Z"
      ></path>
      <path d="M143.65,85.91,136,72.62l3.08-1.77,7.65,13.29Z"></path>
      <path
        d="M151.61,81.33,144,68,147,66.27l3.52,6.12L152.69,63l3.91-2.25-2.42,9.94,10.53,3.09-4.1,2.36-9.62-3,3.69,6.42Z"
      ></path>
      <path
        d="M168.27,68.41l.65,3-3.08,1.77-2.6-16.2L166.62,55,179.4,65.34l-3.08,1.77-2.24-2Zm3.81-5.07-5.88-5.21,0,0,1.55,7.7Z"
      ></path>
      <path
        d="M174.56,50.43l10.71-6.16,1.42,2.47-7.63,4.39,1.79,3.11L188,50.11l1.38,2.39-7.18,4.13,3.06,5.32-3.08,1.77Z"
      ></path>
      <path
        d="M194.38,38.67c3.89-2.24,8.14-.84,10.45,3.19s1.39,8.4-2.5,10.64-8.14.84-10.45-3.19S190.48,40.91,194.38,38.67Zm6.47,11.24c1.73-1,2.57-3.4.91-6.29s-4.16-3.37-5.89-2.37-2.57,3.4-.91,6.29S199.12,50.91,200.84,49.92Z"
      ></path>
      <path
        d="M204.12,33.42l6.3-3.63c3.19-1.84,5.76-1.24,7.09,1.08,1.18,2.05.82,4.58-1.94,6.38l8.69,2.28-4.06,2.34-8.29-2.46-.19.11,3.13,5.43-3.08,1.77Zm6.46,4.12,2.24-1.29c1.79-1,2.44-2.17,1.68-3.49a2,2,0,0,0-2.92-.6l-3.08,1.77Z"
      ></path>
      <path
        d="M233.94,34l-9.29-7.8,0,0L229,36.82l-2.7,1.55L220.9,23.77l2.85-1.64,8.92,7.51,0,0-2-11.48,2.85-1.64,10,12L240.82,30l-7.09-9.07,0,0,2.15,11.91Z"
      ></path>
    </svg>
  </div>
</template>

<script>
export default {
  name: "Logo",

  props: ["isAppLoaded"],

  data() {
    return {
      duration: 3000,
      isAnimated: false
    };
  },

  computed: {
    isLoading() {
      return this.$store.getters.isLoading;
    }
  },

  watch: {
    isLoading: {
      immediate: true,
      handler(isLoading) {
        clearTimeout(this.timeout);
        if (!isLoading) {
          let now = new Date();
          let elapsed = now - this.start;
          let cycle = this.duration / 2;
          let delay = Math.ceil(elapsed / cycle) * cycle - elapsed;
          this.timeout = window.setTimeout(
            this.removeAnimation.bind(this),
            delay
          );
        } else {
          this.addAnimation();
        }
      }
    }
  },

  methods: {
    addAnimation() {
      if (this.isAnimated) return;

      this.start = new Date();
      this.isAnimated = true;
    },

    removeAnimation() {
      this.isAnimated = false;
    }
  }
};
</script>

<style lang="scss">
$logo-color: rgba(#000000, 0.75);

$transition-duration: 0.8s;
$transition-easing: ease-in-out;

.wrapper {
  // horizontal center in viewport
  position: fixed;
  top: 0;
  left: 0;
  transform: translateX(calc(50vw - 50%));
  transition: transform $transition-duration ease-in;

  font-size: 0;
  line-height: 0;

  z-index: 100;
  pointer-events: none;

  &.js-app-loaded {
    transform: translateX(0);
  }
}

.logo {
  width: 300px;
  height: auto;

  // vertical center in viewport
  transform: translateY(calc(50vh - 50%));

  fill: $logo-color;
  transition: transform $transition-duration ease-out;

  .stroke-black {
    fill: none;
    stroke: $logo-color;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 5px;
  }

  .path {
    stroke-dasharray: 402;
    stroke-dashoffset: 0;
  }

  &.js-loading .path {
    animation: dash 3s ease-in-out infinite reverse;
  }

  // When app is loaded, logo moves to the bottom left corner.
  .js-app-loaded & {
    // bottom: 0;
    // left: 0;
    transform: translateY(calc(100vh - 100%));
  }
}

@keyframes dash {
  0% {
    stroke-dasharray: 402;
    stroke-dashoffset: 0;
  }
  12.5% {
    stroke-dasharray: 804;
    stroke-dashoffset: 804;
  }
  37.5% {
    stroke-dasharray: 804;
    stroke-dashoffset: 804;
  }
  50% {
    stroke-dasharray: 402;
    stroke-dashoffset: 0;
  }
  62.5% {
    stroke-dasharray: 804;
    stroke-dashoffset: -402;
  }
  87.5% {
    stroke-dasharray: 804;
    stroke-dashoffset: -402;
  }
  100% {
    stroke-dasharray: 402;
    stroke-dashoffset: 0;
  }
}
</style>
