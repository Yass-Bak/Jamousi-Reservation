<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <form @submit.prevent="handleSubmit">
            <div class="card" style="width: 50rem;">
                <div class="card-body">
                    <h5 class="card-title">Montant à payer : {{ amount }} TND</h5>
                    <br />
                    <div class="card-text">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Saisir votre E-Mail " v-model="email" />
                        </div>
                        <br />
                    </div>
                    <div id="card-element"></div>
                    <br />
                    <button type="submit" class="btn btn-success" :disabled="loading">
                        {{ loading ? 'Traitement...' : 'Procéder au paiement' }}
                    </button>
                     <Popup v-if="popupMessage" :message="popupMessage" :onClose="resetPopup" />
                    <div v-if="error" id="error-div" class="alert alert-danger">
                        {{ error }}
                    </div>
                      <div id="qrcode-container" class="mt-4" style="text-align: center; max-width: 300px; margin: 0 auto;"></div>
                       <div style="display: flex; justify-content: center; align-items: center; margin-top: 15px;">
                            <button v-if="qrCodeDownloadUrl !== null" @click="downloadQRCode" class="btn btn-dark">Télécharger le QR Code</button>
                        </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
import QRCode from 'qrcode-generator';
import store from '../../store';
import api from '../config/api.js';
import Popup from './Popup.vue';
import { useRouter } from 'vue-router';
const qrCodeDownloadUrl = ref(null);
const router = useRouter();
const popupMessage = ref('');
const stripePromise = loadStripe('pk_test_51OYcEbDLzwxtJj2kME2Jv8Js9qL7xv304epRRfPutQoEYAyUBvMDwoB1ziezYObGwgxTdz4K2FS1wc0j6RPqFHc700FSeA0IGk');
const stripe = ref(null);
let cardElement;
let amount = ref(0);
let email = ref('');
let loading = ref(false);
let error = ref(null);

onMounted(async () => {
    amount.value = store.state.Features.cartTotal;
    stripe.value = await stripePromise;
    const elements = stripe.value.elements();
    cardElement = elements.create('card');
    cardElement.mount('#card-element');
});

const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
const resetPopup = () => {
    popupMessage.value = '';
};
const generateQRCode = (paymentCode) => {
    console.log('Payment Code:', paymentCode);
    const typeNumber = 4;
    const errorCorrectionLevel = 'L';
    const qr = QRCode(typeNumber, errorCorrectionLevel);
    qr.addData(paymentCode);
    qr.make();
    const img = qr.createImgTag();
    document.getElementById('qrcode-container').innerHTML = img;
    qrCodeDownloadUrl.value = qr.createDataURL();
};
const downloadQRCode = () => {
    const qrCodeImage = document.getElementById('qrcode-container').getElementsByTagName('img')[0];

    // Check if the image exists
    if (qrCodeImage) {
        const link = document.createElement('a');
        link.href = qrCodeImage.src;
        link.download = 'qrcode.png';
        link.click();
    } else {
        console.error('QR code image not found.');
    }
};

const handleSubmit = async () => {
    try {
        loading.value = true;
        const { token, error } = await stripe.value.createToken(cardElement);

        if (error) {
            throw error;
        }

        // Validate email
        if (!validateEmail(email.value)) {
            throw new Error('Veuillez entrer un e-mail valide.');
        }

        // Validate amount
        if (amount.value <= 0) {
            throw new Error('Veuillez entrer un montant positif.');
        }

        const response = await api.post('/api/createpayment', {
            token: token.id,
            amount: amount.value * 100,
            email: email.value,
        });

        console.log('API Response:', response);

        if (response.data.message) {
            console.log(response.data.message);
           // alert(response.data.message);
            popupMessage.value = response.data.message;
            // Generate QR code
            generateQRCode(response.data.paymentCode);

            // Clear the cart
            store.commit('Features/clearCart');
        } else {
            console.log(response.config);
        }
    } catch (error) {
        console.error(error);
        // Update the error variable with the error message
        error.value = error.message;
    } finally {
        loading.value = false;
    }
};
</script>
