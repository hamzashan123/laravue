<template>
    <div>
        <!-- Header -->
        <!-- <b-card> -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text> <h1>Project Listings</h1> </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'listings.add' }"
                    >
                        Create New Listing
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <!-- </b-card> -->
        <!-- Table -->
        <listing-table />
    </div>
</template>

<script>
import { BCard, BRow, BCol, BButton, BCardText, BLink } from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import ListingTable from "./ListingTable.vue";

export default {
    components: {
        BRow,
        BCol,
        BCard,
        BButton,
        BCardText,
        BLink,
        ListingTable,
    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
