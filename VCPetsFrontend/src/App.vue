<template>
  <MainNavigation></MainNavigation>
  <main>
    <router-view/>
  </main>
</template>

<script>
import MainNavigation from "@/components/MainNavigation";
export default {
  components: {MainNavigation}
}
</script>