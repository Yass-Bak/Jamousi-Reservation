<template>
    <AddProducers/>
    <div class="card">
    <DataTable :value="producers" stripedRows paginator showGridlines :rows="8" dataKey="id" :loading="isLoading">
    <Column header="Image">
    <template #body="{ data }" >
    <img :src="data.imageproducer" :alt=data.nompreproducer class="shadow-4" width="65"/>
    </template>
    </Column>
    <Column field="nompreproducer" header="Nom du Producteur" ></Column>
    <Column field="description" header="Description" sortable></Column>
    <Column field="films" header="Films Produits">
              <template #body="{ data }">
                <ul>
                  <li v-for="film in getFilms(data.id)" :key="film.id">
                    {{ film.nomfilm }}
                  </li>
                </ul>
              </template>
            </Column>
<Column field="id" header="Actions" style="min-width: 12rem">
<template #body="val">
        <div class="d-flex">
        <EditProducers :prod="val.data" />
        <button type="button" class="btn btn-light " @click="deleteproducer(val.data.id)"><span style="color: rgb(0, 0, 0)"><i class="fa-solid fa-trash"></i></span></button>
        </div>
</template>
</Column>
</DataTable>
</div>
</template>

<script setup>
import api from '../config/api.js';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref,onMounted } from 'vue';
import AddProducers from './AddProducers.vue';
import EditProducers from './EditProducers.vue';
const producers=ref([])
const  films = ref([])
const isLoading=ref(true)

    const getproducers=async()=>{
        await api.get("/api/producers")
        .then(res=>{
         producers.value=res.data
        isLoading.value=false
        }).catch(error=>{
    console.log(error) })
        }
const getFilmsData = async () => {
                await api.get("/api/films")
                    .then(res => {
                        films.value = res.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
            const getFilms = (producerId) => {
                return films.value.filter(film => film.producerID === producerId);
            }

            onMounted(() => {
            getproducers();
            getFilmsData();
            });

const deleteproducer=async(id)=>{
    if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
    try {
    await api.delete(`/api/producers/${id}`)
          getproducers()
    } catch (error) {
    console.log(error)

}
}

}




</script>
<style lang="css" scoped>
</style>
