<template>
  <div class="flex bg-white h-screen overflow-hidden">
    <flash-message></flash-message>
    <div
      class="hidden xl:block w-1/2 bg-cover bg-center"
      style='background-image: url("https://images.unsplash.com/photo-1553696353-148be9d0825a?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1534&amp;q=80");'
    ></div>
    <div class="w-full xl:w-1/2 px-8 py-12">
      <form method="POST" action="#" @submit.prevent="submit">
        <h1 class="text-3xl font-bold">Forgot your account password</h1>
        <p class="text-sm text-gray-600">
          Don't have an account?
          <router-link
            :to="{ name: 'register' }"
            class="text-gray-700 font-semibold hover:underline hover:text-gray-900"
            >Sign up</router-link
          >
        </p>
        <div class="mt-4 border-b-2 border-gray-400"></div>
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
        <button
          type="submit"
          class="mt-8 block w-full px-4 py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded focus:outline-none focus:shadow-outline"
        >
          Send Password Reset Link
        </button>
      </form>
    </div>
  </div>
</template>

<script>
  import { guest } from './../../../middleware';

  export default {
    middleware: [
      guest
    ],
    data() {
      return {
        form: {
          email: ''
        },
        message: {
          text: '',
          type: 'success',
        },
        errors: []
      }
    },
    methods: {
      submit() {
        axios.post('/api/v1/password/email', this.form)
            .then((response) => {
              this.message.text = response.data.message;
              this.form.email = '';
              Bus.$emit('flash-message', this.message);
            })
            .catch((error) => {
              this.errors = error.response.data.errors;
            });
      }
    }
  };
</script>
