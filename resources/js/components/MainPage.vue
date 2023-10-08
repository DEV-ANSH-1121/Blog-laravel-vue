<template>
    <Navbar></Navbar>
    <router-view></router-view>
</template>

<style scoped>
a:hover,
a.router-link-active {
    background-color: rgb(13, 110, 50);
}
</style>

<script setup>
import Navbar from './Layouts/Navbar.vue';
import { onMounted } from "vue";
import { useAuthStore } from '@/stores/useAuthStore.js';

const store = useAuthStore();

onMounted(() => {
    store.setUser();
});
</script>
