<template>
    <button type="button" class="btn btn-light "  @click="visible = true">
        <span style="color: rgb(0, 0, 0)">
            <i class="fa-solid fa-pen-to-square"></i>
        </span>
    </button>
   <form >
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
         <div v-if="errors.length > 0" class="alert alert-danger">
        <ul>
            <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
    </div>
        <hr>
        <button type="submit" class="btn btn-outline-success" @click="modifierproducers"><i class="fa-solid fa-floppy-disk"></i> &nbsp Modifier</button>
                 &nbsp
                    <button type="button" className="btn btn-outline-danger" @click="cancel">
                        <i class="fa-solid fa-floppy-disk"></i> &nbsp  Annuler</button>
                </Dialog>
            </div>
        </form>
</template>

<script setup>
import api from '../config/api.js';
import { ref, onMounted } from "vue"
import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import Dialog from 'primevue/dialog';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
// Create FilePond component
const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
import axios from 'axios';
const props = defineProps(['prod'])
const visible = ref(false);
const producer = ref({})

const producers  = ref([]);
const getproducers = async () => {
    await api.get("/api/producers")
        .then(res => {
            producers.value = res.data
            isLoading.value = false
        }).catch(error => {
            console.log(error)
        })
}
const handleFilePondInit = async () => {
    if (producer.value.imageproducer) {

        myFiles.value = [
            {
                source: producer.value.imageproducer,
                options: { type: 'local' }
            }
        ]
    }
}

const loadproducer = () => {

    producer.value = props.prod
}
onMounted(() => {
   getproducers()
    loadproducer()

}
);
const errors = ref([]);
const modifierproducers = async () => {
    try {
        // Clear previous errors
        errors.value = [];

        // Make the API call to update the producer
        await api.put(`/api/producers/${producer.value.id}`, producer.value);

        // Optionally, you may want to handle the successful update here
        visible.value = false;
    } catch (error) {
        // Handle validation errors
        if (error.response && error.response.status === 422) {
            errors.value = Object.values(error.response.data.errors).flat();
        } else {
            console.error("There was an error!", error);
        }
    }
};


const cancel = () => {
    visible.value = false

}
const serverOptions = () => {
    console.log('server pond');
    return {
        load: (source, load, error, progress, abort, headers) => {
            var myRequest = new Request(source);
            fetch(myRequest).then(function (response) {
                response.blob().then(function (myBlob) {
                    load(myBlob);
                });
            });
        },
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
                    console.error('Error uploading file:', error);
                    error('Upload failed');
                    abort();
                });
        },
    };
};


</script>
<style scoped></style>
