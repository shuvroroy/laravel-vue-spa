<template>
  <div class="flex items-center justify-center">
    <div class="relative">
      <div v-if="toggle" @click="toggle = false" class="fixed inset-0"></div>
      <button @click="toggle = !toggle" class="relative flex items-center focus:outline-none">
        <slot name="header"></slot>
      </button>
      <transition
        enter-active-class="transition-all transition-fastest ease-out-quad"
        leave-active-class="transition-all transition-faster ease-in-quad"
        enter-class="opacity-0 scale-70"
        enter-to-class="opacity-100 scale-100"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-70"
      >
        <div v-if="toggle" class="origin-top-right absolute right-0 mt-3 w-64 bg-white rounded-lg border shadow-md py-2">
          <slot name="content"></slot>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
  export default{
    props: ['open'],
    data() {
      return {
        toggle: false
      }
    },
    created() {
      this.toggle = this.open
    }
  };
</script>
