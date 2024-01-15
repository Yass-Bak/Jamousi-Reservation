<!-- Popup.vue -->
<template>
    <div class="popup" v-if="showPopup">
        <div class="popup-content">
            <p>{{ message }}</p>
            <p>Aprés le paiement, un code Qr est généré, Merci de le récupérer</p>
            <button class="btn btn-dark" @click="closePopup">
            <span style="color: rgb(255, 255, 255)"><i class="fa-solid fa-arrow-left "></i></span>
            Retour </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: String,
        onClose: Function,
    },
    data() {
        return {
            showPopup: true,
        };
    },
    methods: {
        closePopup() {
            this.showPopup = false;
            this.onClose();
        },
    },
};
</script>

<style scoped>
.popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-content {
   background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center; /* Center text horizontally */
}
</style>
