<template>
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
  <div class="container-fluid">
    <a routerLink="/"  @click="closeMenu" class="navbar-brand">VCode Pets</a>
    <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation"  >
      <span   @click="openMenu" class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" @click="closeMenu" v-bind:class="isOpen == true ? 'open' : ' '" id="navbarsExampleDefault">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item" >
          <router-link to="/" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item" >
          <router-link to="/pet" class="nav-link">Pets</router-link>
        </li>
        <li class="nav-item" >
          <router-link to="/categories" class="nav-link">Categories</router-link>
        </li>
        <li class="nav-item" >
          <router-link to="/tags" class="nav-link">Tags</router-link>
        </li>
      </ul>
    </div>
  </div>
</nav>

</template>

<script lang="ts">
import {ref} from 'vue';
export default {
  name: "MainNavigation",
  setup() {
    const isOpen = ref(false);
    const closeMenu = () =>{
      isOpen.value = false;
    }
    const openMenu = () =>{
       isOpen.value = true;
    }

    return {
      closeMenu,
      openMenu,
      isOpen
    }
  }
}
</script>
