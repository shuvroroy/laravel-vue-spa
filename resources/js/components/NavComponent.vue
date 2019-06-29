<template>
  <nav class="flex items-center justify-between flex-wrap bg-white shadow p-6">
    <div class="flex items-center flex-shrink-0 mr-6">
      <span class="font-semibold text-xl tracking-tight">Laravel-Vue-Spa</span>
    </div>
    <drop-down :open="false" v-if="user != null">
      <template v-slot:header>
        <span class="ml-2 font-medium">{{ user.name }}</span>
        <svg class="ml-1 h-5 w-5 fill-current text-gray-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z"/>
        </svg>
      </template>

      <template v-slot:content>
        <ul>
          <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-800 hover:text-white">Profile</a>
          </li>
          <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-800 hover:text-white">Account settings</a>
          </li>
          <li>
            <a href="#" class="block px-4 py-2 hover:bg-gray-800 hover:text-white" @click.prevent="submit">Sign out</a>
          </li>
        </ul>
      </template>
    </drop-down>
  </nav>
</template>

<script>
  import { mapActions } from 'vuex';

  export default {
    props: ['user'],
    methods: {
      ...mapActions({
        logout: 'auth/logout'
      }),
      submit() {
        this.logout().then(() => {
          this.$router.replace({ name: 'login'});
        });
      }
    }
  };
</script>
