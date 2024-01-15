
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
}

router-view {
    flex: 1;
    /* Allow router-view to take up the remaining vertical space */
}

Footer {
    flex-shrink: 0;
    /* Prevent the footer from shrinking when content is small */
    background-color: #ffffff;
    padding: 4px;
    margin-top: auto;
}
</style>
