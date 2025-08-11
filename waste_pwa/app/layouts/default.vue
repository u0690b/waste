<template>
  <div class="h-screen flex flex-col justify-between">
    <AppHeader />
    <div class="flex-auto" >
      <slot />
    </div>
    <AppFooter />
  </div>
</template>