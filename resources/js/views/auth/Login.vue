<template>
  <div class="flex bg-white h-screen overflow-hidden">
    <div
      class="hidden xl:block w-1/2 bg-cover bg-center"
      style='background-image: url("https://images.unsplash.com/photo-1553696353-148be9d0825a?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1534&amp;q=80");'
    ></div>
    <div class="w-full xl:w-1/2 px-8 py-12">
      <h1 class="text-3xl font-bold">Sign in to your account</h1>
      <p class="text-sm text-gray-600">
        Don't have an account?
        <router-link
          :to="{ name: 'register' }"
          class="text-gray-700 font-semibold hover:underline hover:text-gray-900"
          >Sign up</router-link>
      </p>
      <div class="mt-4 border-b-2 border-gray-400"></div>
      <form method="POST" action="#" @submit.prevent="submit">
        <div class="mt-6">
          <label class="block">
            <span class="block text-sm text-gray-700 font-semibold">Email</span>
            <input
              type="email"
              placeholder="Your email address"
              class="mt-2 block w-full px-4 py-3 bg-gray-200 border border-transparent rounded focus:bg-white focus:border-gray-400 focus:outline-none"
              v-model="form.email"
            />
          </label>
          <p class="text-red-500 text-sm italic mt-1" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>
        <div class="mt-6">
          <label class="block">
            <span class="block text-sm text-gray-700 font-semibold">Password</span>
            <input
              type="password"
              placeholder="********"
              class="mt-2 block w-full px-4 py-3 bg-gray-200 border border-transparent rounded focus:bg-white focus:border-gray-400 focus:outline-none"
              v-model="form.password"
            />
          </label>
          <p class="text-red-500 text-sm italic mt-1" v-if="errors.password">{{ errors.password[0] }}</p>
        </div>
        <div class="mt-6">
          <div class="flex justify-between items-center">
            <label class="form-checkbox-group">
              <input type="checkbox" v-model="form.remember" />
              <span class="form-checkbox-indicator" aria-hidden></span>
              <span class="text-sm text-gray-700 font-semibold select-none ml-2">Remember me</span>
            </label>
            <router-link
              :to="{ name: 'password.request' }"
              class="text-sm text-gray-600 hover:text-gray-900 hover:underline">
              Forgot your password?
            </router-link>
          </div>
        </div>
        <button
          type="submit"
          class="mt-8 block w-full px-4 py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded focus:outline-none focus:shadow-outline"
        >
          Sign in
        </button>
      </form>
    </div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex';
  import { guest } from './../../middleware';

  export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
          remember: false
        },
        errors: []
      }
    },
    middleware: [
      guest
    ],
    methods: {
      ...mapActions({
        login: 'auth/login'
      }),
      submit() {
        this.login({
          payload: this.form
        }).then(() => {
          this.$router.replace({ name: 'dashboard'});
        }).catch((error) => {
          this.errors = error.response.data.errors;
        });
      }
    }
  };
</script>
