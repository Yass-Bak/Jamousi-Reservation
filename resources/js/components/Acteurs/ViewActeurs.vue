<template>
    <AddActeurs />
    <div class="card">
        <DataTable :value="Acteurs" stripedRows paginator showGridlines :rows="8" dataKey="id" :loading="isLoading">
            <Column header="Image">
                <template #body="{ data }">
                    <img :src="data.imageacteur" :alt=data.nompreacteur class="shadow-4" width="65" />
                </template>
            </Column>
            <Column field="nompreacteur" header="Nom du Acteur"></Column>
            <Column field="description" header="Description" sortable></Column>
            <Column field="" header="Participation" sortable></Column>
            <Column field="id" header="Actions" style="min-width: 12rem">
                <template #body="val" >
                    <div class="d-flex">
                        <EditActeurs :act="val.data" :isLoading="isLoading"  />
                        <button type="button" class="btn btn-light " @click="deleteActeurs(val.data.id)"><span
                                style="color: rgb(0, 0, 0)"><i class="fa-solid fa-trash"></i></span> Supprimer</button>
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
import { ref, onMounted } from 'vue';
import AddActeurs from './AddActeurs.vue';
import EditActeurs from './EditActeurs.vue';
const Acteurs = ref([])
const isLoading = ref(true)
const props = defineProps(['act', 'isLoading']);
const getActeurs = async () => {
    await api.get("/api/acteurs")
        .then(res => {
            Acteurs.value = res.data
            isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}


onMounted(() => {
    getActeurs();
});

const deleteActeurs = async (id) => {
    if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
        try {
            await api.delete(`/api/acteurs/${id}`)
            getActeurs()

        } catch (error) {
            console.log(error)

        }
    }

}
</script>
<style lang="css" scoped></style>
