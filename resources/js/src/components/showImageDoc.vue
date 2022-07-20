<template>
    <div>

        <div class="d-flex flex-wrap mb-2">
            <b-img
                v-for="(image, idx) in aimages"
                :key="idx"
                fluid
                thumbnail
                class="w-50 listing-image-fixed-height"
                :src="image"
                @click="index = idx"
            />
        </div>

        <CoolLightBox
        :items="aimages ? aimages : []"
        :index="index"
        @close="index = null">
        </CoolLightBox>

        <div v-for="(doc, idx) in adocs" :key="idx">
            <b-button
                variant="flat-primary"
                class="p-0 mb-1"
                :href="doc"
                target="_blank"
            >
                <b-avatar
                    variant="light-dark"
                    square
                    size="md"
                    :text="showExt( doc )"
                />
            </b-button>

            <b-button
                variant="outline-dark"
                size="sm"
                target="_blank"
                :href="doc"
            >
                View
            </b-button>
        </div>
    </div>
</template>

<script>
import { BImg, BAvatar, BButton } from "bootstrap-vue";

import CoolLightBox from 'vue-cool-lightbox'
import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'

export default {
    props: ["listing"],
    components: {
        BImg,
        BAvatar,
        BButton,

        CoolLightBox,
    },
    data() {
        return {
            index: null,
            sliderImages: [],
            docs: [],

        }
    },
    computed: {
        aimages() {
            return this.getImages( this.listing.images )
        },
        adocs() {
            return this.getDocs( this.listing.images )
        },
    },
    methods: {

        getImages( links ) {
            let i = []
            links ? links.forEach(( link ) => {
                if( this.checkImage( link ) ) {
                    i.push( link )
                }
            }) : ''
            return i
        },

        getDocs( links ) {
            let i = []
            links ? links.forEach(( link ) => {
                console.log("in link", link);

                if( !this.checkImage( link ) ) {
                    i.push( link )
                }
            }) : ''
            return i
        },

        checkImage( link ) {
            var extension = link.split('.').pop().toLowerCase();
            let imgExts = ['jpeg', 'jpg', 'png']
            return imgExts.includes(extension) ? true : false
        },
         showExt( link ) {
            return link.split('.').pop();
         }

    },

};
</script>

<style></style>
