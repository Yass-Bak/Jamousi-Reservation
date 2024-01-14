<template>
    <div class="drag">
        <div v-if="isLoading">
        </div>
        <div v-else class="row">
            <div class="col-md-12" style="display:flex;flex-wrap:wrap;justify-content:center">
                <div class="card" style="width: 18rem;margin:6px" v-for="film in Films" :key="film.id">
                      <img :src="film.imagefilm" :alt=film.nomfilm class="w-100" height="300">
                    <div class="card-body">
                        <div style="text-align:center">
                            <b class="card-title">{{ film.nomfilm }}</b>
                            <p class="card-text">{{ film.description.substr(0, 80) }}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Prix : {{ film.prix }} TND</li>
                            </ul>
                            <status-card :item="film"></status-card>
                            <button class="btn btn-outline-primary" @click="addToCart(film)" v-if="film.nbplaces > 1">
                                Réserver Ticket</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import store from '../../store'
import api from '../config/api.js';
import StatusCard from "./StatusCard.vue";
import { ref, onMounted , computed } from 'vue';
const Films = ref([]);
const isLoading = ref(true)
onMounted(() => {
    getfilms();
});

const getfilms = () => {

    api.get('/api/films').then(res => {
       Films.value = res.data;
       isLoading.value = false
    }).catch(error => {
        console.log(error)
    });

}


const addToCart = (film) => {
    store.commit("Features/addCart", { product: film, qty: 1 });

}
const filteredFilms = computed(() => {
    return Films.value.filter(film =>
        film.nomfilm.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});
</script>
<style scoped>
    .drag {
        margin-top: 70px;
    }
</style>
