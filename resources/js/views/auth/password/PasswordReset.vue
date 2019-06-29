<template>
  <div class="flex bg-white h-screen overflow-hidden">
    <flash-message></flash-message>
    <div
      class="hidden xl:block w-1/2 bg-cover bg-center"
      style='background-image: url("https://images.unsplash.com/photo-1553696353-148be9d0825a?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1534&amp;q=80");'
    ></div>
    <div class="w-full xl:w-1/2 px-8 py-12">
      <form method="POST" action="#" @submit.prevent="submit">
        <h1 class="text-3xl font-bold">Reset Your Password</h1>
        <div class="mt-4 border-b-2 border-gray-400"></div>
        <div class="mt-6">
          <label class="block">
            <span class="block text-sm text-gray-700 font-semibold">Email</span>
            <input
              type="email"
              placeholder="Your email address"
              class="mt-2 block w-full px-4 py-3 bg-gray-200 border border-transparent rounded select-none focus:outline-none"
              v-model="form.email"
              readonly
            />
          </label>
          <p class="text-red-500 text-sm italic mt-1" v-if="errors.email">{{ errors.email[0] }}</p>
        </div>
        <div class="mt-6">
          <div class="flex flex-wrap -mx-4">
            <div class="w-full md:w-1/2 px-4">
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
            <div class="w-full md:w-1/2 px-4 mt-6 md:mt-0">
              <label class="block">
                <span class="block text-sm text-gray-700 font-semibold">Confirm Password</span>
                <input
                  type="password"
                  placeholder="********"
                  class="mt-2 block w-full px-4 py-3 bg-gray-200 border border-transparent rounded focus:bg-white focus:border-gray-400 focus:outline-none"
                  v-model="form.password_confirmation"
                />
              </label>
            </div>
          </div>
        </div>
        <button
          type="submit"
          class="mt-8 block w-full px-4 py-3 bg-gray-800 hover:bg-gray-700 text-white font-semibold rounded focus:outline-none focus:shadow-outline"
        >
          Reset Password
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
          token: '',
          email: '',
          password: '',
          password_confirmation: ''
        },
        message: {
          text: '',
          type: 'success',
        },
        errors: []
      }
    },
    created() {
      this.form.email = this.$route.query.email;
      this.form.token = this.$route.params.token;
    },
    methods: {
      submit() {
        axios.post('/api/v1/password/reset', this.form)
            .then((response) => {
              this.message.text = response.data.message;
              Bus.$emit('flash-message', this.message);
              setTimeout(() => {
                this.$router.replace({ name: 'login'});
              }, 3000);
            })
            .catch((error) => {
              this.errors = error.response.data.errors;
            });
      }
    }
  };
</script>
