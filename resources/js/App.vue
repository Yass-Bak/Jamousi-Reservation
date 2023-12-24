
<script setup>
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';
</script>
<template>
    <Menu />
    <router-view></router-view>
    <Footer />
</template>

<style scoped>
#app {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    /* Ensure the container takes at least the full viewport height */
}

router-view {
    flex: 1;
    /* Allow router-view to take up the remaining vertical space */
}

Footer {
    margin-top: auto;
    /* Use auto margin to push the footer to the bottom */
    position: sticky;
    bottom: 0;
    /* Stick the footer to the bottom of the container */
    background-color: #ffffff;
    /* Add a background color to the sticky footer if needed */
    padding: 4px;
    /* Add padding for better appearance */
}</style>
