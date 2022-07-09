<template>
    <div>
        <div class="d-flex flex-wrap mb-2">
            <b-img
                v-for="(image, idx) in listing.images"
                :key="idx"
                fluid
                thumbnail
                class="w-50 listing-image-fixed-height"
                :src="image"
                @click="index = idx"
            />
        </div>
        <div v-if="!listing.images">No images found</div>

        <CoolLightBox
        :items="listing.images ? listing.images : []"
        :index="index"
        @close="index = null">
        </CoolLightBox>

    </div>
</template>

<script>
import { BImg } from "bootstrap-vue";

import CoolLightBox from 'vue-cool-lightbox'
import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'

export default {
    props: ["listing"],
    components: {
        BImg,

        CoolLightBox,
    },
    data() {
        return {
            index: null,

        }
    },
};
</script>

<style></style>
