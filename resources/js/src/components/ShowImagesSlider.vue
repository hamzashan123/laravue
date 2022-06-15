<template>
    <div>
        <div class="d-flex flex-wrap mb-2">
            <b-img
                v-for="(image, idx) in listing.images"
                :key="idx"
                fluid
                thumbnail
                class="w-50"
                :src="image"
                v-b-modal.modal-listing-images
            />
        </div>
        <div v-if="!listing.images">No images found</div>

        <!-- modal -->
        <b-modal id="modal-listing-images" ok-only centered size="lg">
            <swiper
                class="swiper-navigations"
                :options="swiperOptions"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
            >
                <swiper-slide
                    v-for="(image, index) in listing.images"
                    :key="index"
                >
                    <b-img :src="image" fluid />
                </swiper-slide>

                <!-- Add Arrows -->
                <div slot="button-next" class="swiper-button-next" />
                <div slot="button-prev" class="swiper-button-prev" />
            </swiper>
        </b-modal>
    </div>
</template>

<script>
import { BImg, BModal, } from "bootstrap-vue";
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'

export default {
    props: ["listing"],
    components: {
        BImg,
        BModal,

        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            swiperOptions: {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            },
        }
    }
};
</script>

<style></style>
