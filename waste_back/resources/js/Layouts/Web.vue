<template>
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div>
      <ILink href="/">
        <breeze-application-logo class="w-20 h-20 fill-current text-gray-500" />
      </ILink>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md  max-w-3x sm:rounded-lg">
      <slot />
    </div>
  </div>
</template>

<script>
  import BreezeApplicationLogo from '@/Components/ApplicationLogo'

  export default {
    components: {
      BreezeApplicationLogo,
    },
  }
</script>
