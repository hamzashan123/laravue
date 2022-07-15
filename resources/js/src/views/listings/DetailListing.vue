<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Visits on {{ listing.title }}</h1>
                    <b-badge :variant="statuses_color[1][listing.status]" v-if="listing.status">
                        {{ statuses_color[0][listing.status] }}
                    </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'listings.view' }"
                    >
                        Back to Listing
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'listings' }"
                    >
                        All Listings
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <!-- Date and amount Form -->
        <b-form @submit.prevent enctype="multipart/form-data">
            <validation-observer ref="validationRules">
                <b-card>
                    <show-client-date-budget :listing="listing" />
                </b-card>

                <!-- Images and Detail -->
                <b-card>
                    <b-row>
                        <!-- Visting detail -->
                        <b-col md="6" class="mb-2">
                            <h4 class="mb-2">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Updates About Project
                            </h4>

                            <app-timeline>
                                <app-timeline-item variant="secondary" v-for="(visit, index) in listingVisit" :key="index">
                                    <div
                                        class="
                                            d-flex
                                            align-items-center
                                            flex-sm-row flex-column flex-wrap
                                            mb-1 mb-sm-50
                                        "
                                    >
                                        <h6 class="mr-auto">{{ visit.visit_summary }} - {{ visit.percentage }}%</h6>
                                        <b-button
                                            v-if="can('update', 'listing') || can('update', 'all-listing')"
                                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                            variant="warning"
                                            class="mr-1"
                                            size="sm"
                                        >
                                            <feather-icon icon="EditIcon" size="15" />
                                        </b-button>
                                        <!-- delete -->
                                        <b-button
                                            v-if="can('update', 'listing') || can('update', 'all-listing')"
                                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                            variant="danger"
                                            class="mr-1"
                                            size="sm"
                                            @click="deleteTrigger( visit.id, index )"
                                        >
                                            <feather-icon icon="XIcon" size="15" />
                                        </b-button>
                                        <b-button
                                            v-ripple.400="
                                                'rgba(113, 102, 240, 0.15)'
                                            "
                                            variant="outline-primary"
                                            @click="changeVisitData(index)"
                                        >
                                            <span class="align-middle"
                                                >{{ visit.visit_date }}</span
                                            >
                                            <feather-icon
                                                icon="CalendarIcon"
                                                class="mr-50"
                                            />
                                        </b-button>
                                    </div>
                                    <div class="progress-wrapper">
                                        <b-progress
                                            :value="visit.percentage"
                                            max="100"
                                            show-value
                                            height="20px"
                                        />
                                    </div>
                                </app-timeline-item>

                            </app-timeline>
                        </b-col>
                        <!-- Details Form -->
                        <b-col md="6" class="mb-2">
                            <show-title-description heading="Listing Details" :listing="listing" />

                            <show-images-slider :listing="listing" />
                            <!-- <b-row>
                                <b-col lg="6" class="mb-2">
                                    <show-map lat=20.5937 lng=78.9629 />
                                </b-col>
                                <b-col lg="6">
                                    <show-address :listing="listing"/>
                                </b-col>
                            </b-row> -->

                         </b-col>
                    </b-row>
                </b-card>
            </validation-observer>
        </b-form>
    </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
    BCard,
    BRow,
    BCol,
    BButton,
    BCardText,
    BLink,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BFormDatepicker,
    BForm,
    BFormSelect,
    BImg,
    BFormFile,
    BFormTextarea,
    BEmbed,
    BSpinner,
    BBadge,
    VBTooltip,
    BProgress,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import AppTimeline from "@core/components/app-timeline/AppTimeline.vue";
import AppTimelineItem from "@core/components/app-timeline/AppTimelineItem.vue";
import { mapActions, mapGetters } from "vuex";
import { required } from "@validations";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { statuses_color } from "@/fieldsdata/index.js";
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'
import ShowTitleDescription from '@/components/ShowTitleDescription.vue'
import ShowAddress from '@/components/ShowAddress.vue'
import ShowImagesSlider from '@/components/ShowImagesSlider.vue'
import ShowClientDateBudget from '@/components/ShowClientDateBudget.vue'
import { can } from '@/auth/authentication.js'

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BCard,
        BButton,
        BCardText,
        BLink,
        BFormGroup,
        BFormInput,
        BFormCheckbox,
        BFormDatepicker,
        BForm,
        BFormSelect,
        BImg,
        BFormFile,
        BFormTextarea,
        BEmbed,
        BSpinner,
        BBadge,
        VBTooltip,
        BProgress,
        AppTimeline,
        AppTimelineItem,
        Swiper,
        SwiperSlide,
        ShowTitleDescription,
        ShowAddress,
        ShowImagesSlider,
        ShowClientDateBudget,
    },
    data() {
        return {
            swiperOptions: {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            },
            // listing
            imagesShowWhileUpload: [],
            id: "",
            listing: {},
            listingVisit: {},
            //   Validation
            required,
            activeVisitData: false,
            statuses_color,
            // check user
            can,
        };
    },
    methods: {
        ...mapActions({ loadListingVisits: "listing/loadListingVisits", deleteVisit: "listing/deleteVisit" }),

        changeVisitData( index ) {
            this.activeVisitData = true
            this.listing.images = this.listingVisit[index].images
            this.listing.description = this.listingVisit[index].visit_detail
        },

        deleteTrigger( id, index ) {
            if( confirm("Are you sure?") ) {

                this.deleteVisit({ visit_id: id })
                    .then((response) => {
                        if(response.success) {
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: response.message,
                                    icon: "EditIcon",
                                    variant: "success",
                                },
                            });
                            this.listingVisit.splice(index, 1)
                        }

                    })
                    .catch((error) => {
                        console.log(error);
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: "Error while loading",
                                icon: "EditIcon",
                                variant: "danger",
                            },
                        });
                    });
            }

        },
    },
    computed: {
        ...mapGetters({
            isLoading: "listing/getIsLoading",
        }),
    },
    mounted() {

        this.id = this.$route.params.listingId;

        this.loadListingVisits({ listing_id: this.id })
            .then((response) => {
                if (response.success) {
                    this.listing = response.data[0].listing;
                    this.listingVisit = response.data;
                    console.log(response.data);
                } else {
                    this.$toast({
                        component: ToastificationContent,
                        props: {
                            title: response.message,
                            icon: "EditIcon",
                            variant: "danger",
                        },
                    });
                }
            })
            .catch((error) => {
                console.log(error);
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error while loading",
                        icon: "EditIcon",
                        variant: "danger",
                    },
                });
            });
    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
