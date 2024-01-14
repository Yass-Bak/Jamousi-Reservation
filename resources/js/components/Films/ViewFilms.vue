<template>
    <AddFilms />
    <div class="card">
        <DataTable :value="films" stripedRows paginator showGridlines :rows="8" dataKey="id" :loading="isLoading">
            <Column header="Image">
                <template #body="{ data }">
                    <img :src="data.imagefilm" :alt="data.nomfilm" class="shadow-4" width="65" />
                </template>
            </Column>
            <Column field="nomfilm" header="Nom du Film"></Column>
            <Column field="description" header="Description" sortable></Column>
            <Column field="typeven" header="Type" sortable></Column>
            <Column field="prix" header="Prix" sortable></Column>
            <Column field="nbplaces" header="Nombres de places" sortable></Column>
            <Column field="datedeb" header="Date Debut" sortable></Column>
            <Column field="datefin" header="Date Fin" sortable></Column>
            <Column header="Nom du producteur" style="min-width: 150px">
                <template #body="{ data }">
                    {{ getProducerName(data.producerID) }}
                </template>
            </Column>
             <Column field="acteurs" header="Acteurs" style="min-width: 150px">
        <template #body="{ data }">
            <div v-if="data.acteurs && data.acteurs.length">
                <div v-for="actor in data.acteurs" :key="actor.id">
                    {{ actor.nompreacteur }}
                </div>
            </div>
            <div v-else>
         Aucun acteur disponible
            </div>
        </template>
    </Column>

            <Column field="id" header="Actions" style="min-width: 12rem">
                <template #body="val">
                    <div class="d-flex">
                        <EditFilms :flm="val.data" :isLoading="isLoading"  />
                        <button type="button" class="btn btn-light " @click="deletefilms(val.data.id)">
                            <span style="color: rgb(0, 0, 0)"><i class="fa-solid fa-trash"></i></span> Supprimer
                        </button>
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<script setup>
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import { onMounted, ref } from 'vue';
import api from '../config/api.js';

import AddFilms from './AddFilms.vue';
import EditFilms from './EditFilms.vue';
const films = ref([]);
const producers = ref([]);
const isLoading = ref(true);
const props = defineProps(['flm' , 'isLoading']);
const getfilms = async () => {
    try {
        const response = await api.get("/api/films");

        if (response.data) {
            films.value = response.data.map(film => ({...film,
                acteurs: Array.isArray(film.acteurs)
                    ? film.acteurs.map(actor => ({
                        nompreacteur: actor.nompreacteur,
                        // Add other actor properties if needed
                    }))
                    : [], // Handle the case where film.acteurs is undefined or not an array
            }));
        }

        isLoading.value = false;
    } catch (error) {
        console.error(error);
    }
};



const getproducers = async () => {
    try {
        const response = await api.get("/api/producers");
        producers.value = response.data;
        isLoading.value = false;
    } catch (error) {
        console.log(error);
    }
};

const getProducerName = (producerID) => {
    const producer = producers.value.find(p => p.id === producerID);
    return producer ? producer.nompreproducer : '';
};

onMounted(() => {
    getfilms();
    getproducers();
});

const deletefilms = async (id) => {
    if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
        try {
            await api.delete(`/api/films/${id}`);
            getfilms();
        } catch (error) {
            console.log(error);
        }
    }
};
</script>

<style lang="css" scoped>
/* Add your custom styles here if needed */
</style>
