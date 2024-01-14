<template>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <button type="button" class="btn btn-dark" @click="visible = true">
                <span style="color: rgb(255, 255, 255)">
                    <i class="fa-solid fa-square-plus"> </i>
                </span>
                Ajout d'un Evenement
            </button>
        </div>
    </nav>
    <form @submit.prevent="addfilm">
        <div class="card flex content-center"  >
            <Dialog v-model:visible="visible" >
                <div  class="row custom-row">
                    <div class="col-md-6 ms-auto">
                        <label for="nomfilm" class="form-label">Nom du Film</label>

                        <input type="text" class="form-control" id="nomfilm" v-model="film.nomfilm">

                    </div>
                    <div class="col-md-6 ms-auto">
                        <label for="description" class="form-label">Description</label>

                        <textarea class="form-control" id="description" v-model="film.description"></textarea>
                    </div>
                    <div class="col-md-6 ms-auto">
                    <label for="typeven" class="form-label">Type</label>
                      <select class="form-control" id="typeven" v-model="film.typeven">
                                <!-- Utiliser les types récupérés depuis votre base de données -->
                                <option v-for="type in types" :key="type" :value="type">{{ type }}</option>
                            </select>
                            </div>
                            <div class="col-md-6 ms-auto">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="text" class="form-control" id="prix" v-model="film.prix">
                        </div>
                        <div class="col-md-6 ms-auto">
                                <label for="nbplaces" class="form-label">Nombre de places</label>
                                <input type="text" class="form-control" id="nbplaces" v-model="film.nbplaces">
                            </div>
                        <div class="col-md-6 ms-auto">
                                <label for="datedeb" class="form-label">Date Début</label>
                                <input type="date" class="form-control" id="datedeb" v-model="film.datedeb">
                            </div>
                            <div class="col-md-6 ms-auto">
                                    <label for="datefin" class="form-label">Date Fin</label>
                                    <input type="date" class="form-control" id="datefin" v-model="film.datefin">
                                </div>
                                 <div class="col-md-6 ms-auto">
                            <label for="Producers" class="form-label">Producteur</label>
                            <select class="form-control" v-model="film.producerID">
                            <option v-for="prod in Producers" :key="prod.id" :value=prod.id>{{ prod.nompreproducer }} </option>
                            </select>
                            </div>
        <div class="col-md-6 ms-auto">
        <label for="acteurs" class="form-label">Acteurs</label>
        <select multiple class="form-control" id="acteurs" v-model="film.acteurIDs">
            <option v-for="acteur in Acteurs" :key="acteur.id" :value="acteur.id">{{ acteur.nompreacteur }}</option>
        </select>
    </div>
                </div>
                <hr>
                <div class="row">
                    <file-pond name="test" ref="pond" class-name="my-pond" label-idle="Déposer les fichiers ici..."
                        allow-multiple="false" accepted-file-types="image/jpeg, image/png" v-bind:files="myFiles"
                        :server="serverOptions()" />
                </div>

                <hr>
                <div v-if="errors.length" class="alert alert-danger">
                    <ul>
                        <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                </div>
                <hr>
                <button type="submit" className="btn btn-outline-success" @click="addfilm">
                    <i class="fa-solid fa-floppy-disk"></i> Ajouter</button>
                &nbsp
                <button type="button" className="btn btn-outline-danger" @click="cancel">
                    <i class="fa-solid fa-floppy-disk"></i> Annuler </button>
            </Dialog>
        </div>
    </form>
</template>

<script setup>
import { ref, onMounted } from "vue"
import api from '../config/api.js';
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import Dialog from 'primevue/dialog';

import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
import axios from "axios";
const visible = ref(false);
const film = ref({
    nomfilm: "",
    description: "",
    imagefilm: "/img/img2",
    typeven: "",
    prix: "",
    nbplaces: "",
    datedeb: "",
    datefin: "",
    producerID: "",
    acteurIDs: [] // Array to hold selected actor IDs
});
const films = ref([]);
const getfilms = () => {

    api.get('/api/films').then(res => {
        films.value = res.data;
    }).catch(error => {
        console.log(error)
    });

}
const Acteurs = ref([]);
const getActeurs = () => {
    api.get('/api/acteurs').then(res => {
        Acteurs.value = res.data;
    }).catch(error => {
        console.log(error);
    });
};

const types = ['film', 'stand_up', 'théatre'];
const errors = ref([]);
const Producers = ref([]);
const getProducers = () => {

    api.get('/api/producers').then(res => {
        Producers.value = res.data;
    }).catch(error => {
        console.log(error)
    });

}
const addfilm  = async () => {
    try {
        errors.value = [];
        await api.post("/api/films/", film.value);
        visible.value = false;
        window.location.reload();
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = Object.values(error.response.data.errors).flat();
        } else {
            console.error(error);
        }
    }
};
onMounted(() => {
    getfilms();
    getProducers();
     getActeurs();
}


);
const handleFilePondInit = () => {
    console.log('FilePond has initialized');
}
const cancel = () => {
    visible.value = false
}
const serverOptions = () => {
    console.log('server pond');
    return {
        process: (fieldName, file, metadata, load, error, progress, abort) => {
            const data = new FormData();
            data.append('file', file);
            data.append('upload_preset', 'GLID5IIT');
            data.append('cloud_name', 'esps');
            data.append('public_id', file.name);
            axios.post('https://api.cloudinary.com/v1_1/esps/upload', data)
                .then((response) => response.data)
                .then((data) => {
                    console.log('Cloudinary Response:', data);
                   film.value.imagefilm = data.url;
                    load(data);
                })
                .catch((error) => {
                    console.error('Erreur de téléchargement du fichier :', error);
                    error('Erreur de téléchargement du fichier ');
                    abort();
                });
        },
    };
};
</script>
<style scoped>
.custom-row {
  /* Set a specific height for the row */
  height: auto;
  width: 600px;/* Adjust the height as needed */
  /* Add any other custom styles for the row */
}
</style>

