<template>
    <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">
             <button type="button" class="btn btn-dark" @click="visible = true">
                <span style="color: rgb(255, 255, 255)">
                <i class="fa-solid fa-square-plus"> </i>
              </span>
              Ajout d'un Producteur
                </button>
                 </div>
                 </nav>
    <form @submit.prevent="addProducer">
        <div class="card flex justify-content-center">
            <Dialog v-model:visible="visible">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nompreproducer" class="form-label">Nom du producteur</label>

                        <input type="text" class="form-control" id="nompreproducer" v-model="producer.nompreproducer">

                    </div>
                    <div class="col-md-6 ms-auto">
        <label for="description" class="form-label">Bio</label>

        <textarea class="form-control" id="description" v-model="producer.description"></textarea>
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
                <button type="submit" className="btn btn-outline-success" @click="addProducer">
                    <i class="fa-solid fa-floppy-disk"></i>Ajouter</button>
     &nbsp
                <button type="button" className="btn btn-outline-danger" @click="cancel">
                    <i class="fa-solid fa-floppy-disk"></i>cancel </button>
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
const producer = ref({
    nompreproducer: "",
    description: "",
    imageproducer: "/img/img1",
})
const films = ref([]);
const getfilms = () => {

    api.get('/api/films').then(res => {
        films.value = res.data;
    }).catch(error => {
        console.log(error)
    });

}

const errors = ref([]);

const addProducer = async () => {
    try {
        // Clear previous errors
        errors.value = [];

        // Your existing code for adding a producer
        await api.post("/api/producers/", producer.value);
        visible.value = false;
        window.location.reload();
    } catch (error) {
        // Handle validation errors
        if (error.response && error.response.status === 422) {
            errors.value = Object.values(error.response.data.errors).flat();
        } else {
            console.error(error);
        }
    }
};
onMounted(() => {
   getfilms();
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
                    console.log(data);

                    producer.value.imageproducer = data.url;
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
<style scoped></style>
