<template>
    <p class="card-text" v-if="item && item.datedeb && item.datefin">
        <b>Status: </b>
        <span :class="statusClass">{{ statusText }}</span>
    </p>
    <p class="card-text" v-else>
        Item, datedeb, or datefin is missing or undefined.
    </p>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
    computed: {
        statusText() {
            if (this.item && this.item.datedeb && this.item.datefin) {
                const currentDate = new Date();
                const startDate = new Date(this.item.datedeb);
                const endDate = new Date(this.item.datefin);

                if (currentDate >= startDate && currentDate <= endDate) {
                    return 'DISPONIBLE';
                } else if (currentDate > endDate) {
                    return 'EXPIRE';
                } else {
                    return 'A VENIR';
                }
            } else {
                return 'élément, datedeb ou datefin est manquant ou indéfini.';
            }
        },
        statusClass() {
            const status = this.statusText.toLowerCase();
            return {
                'badge': true,
                'bg-success': status === 'disponible',
                'bg-danger': status === 'expire',
                'bg-primary': status === 'a venir',
                'text-white': true,
            };
        },
    },
};
</script>
