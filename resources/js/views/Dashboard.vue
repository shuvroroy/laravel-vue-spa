<template>
  <div>
    <nav-bar></nav-bar>
  </div>
</template>

<script>
  import NavBar from '../components/NavComponent'
  export default {
    components: {
      NavBar
    },
    data() {
      return {
        open: false
      }
    },
  }
</script>
