<template>
  <div>
    App
  </div>
  <router-link :to="{ name: 'router.test' }">page link</router-link>
  <router-view></router-view>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style scoped>

</style>
