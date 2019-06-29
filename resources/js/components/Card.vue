<template>
  <div class="bg-white rounded-lg shadow-md px-6 py-6">
    <slot name="header"><h2 class="font-semibold text-gray-900 text-2xl leading-tight border-b-2 border-gray-200 pb-4">Delete account</h2></slot>

    <slot name="default"><p class="mt-4 text-gray-700">We'll cancel your subscription and remove all of your data from our servers.</p></slot>

    <slot name="footer"><div class="mt-6"></div></slot>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        open: false
      }
    }
  };
</script>
