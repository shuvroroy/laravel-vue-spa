<template>
  <div>
    <nav-component :user="user"></nav-component>
  </div>
</template>

<script>
  import { auth } from './../middleware';
  import { mapGetters, mapActions } from 'vuex';

  export default {
    middleware: [
      auth
    ],
    computed: {
      ...mapGetters({
        user: 'auth/user'
      })
    },
    created() {
      this.fetchUser();
    },
    methods: {
      ...mapActions({
        fetchUser: 'auth/fetchUser'
      }),
    }
  };
</script>
