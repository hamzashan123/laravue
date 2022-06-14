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
                    <b-row>
                        <b-col md="6">
                            <h4 class="mb-2 text-primary">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Target Compilation date Range
                            </h4>

                            <div class="form-row">
                                <div class="col">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="From Date"
                                        rules="required"
                                    >
                                        <b-form-datepicker
                                            placeholder="Select From Date"
                                            id="target_completion_datefrom"
                                            class="mb-1 p-0"
                                            v-model="
                                                listing.target_completion_datefrom
                                            "
                                            name="target_completion_datefrom"
                                            :state="
                                                errors.length > 0 ? false : null
                                            "
                                            disabled
                                        />
                                        <small class="text-danger">{{
                                            errors[0]
                                        }}</small>
                                    </validation-provider>
                                </div>
                                <div class="col">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="To Date"
                                        rules="required"
                                    >
                                        <b-form-datepicker
                                            placeholder="Select To Date"
                                            id="target_completion_dateto"
                                            v-model="
                                                listing.target_completion_dateto
                                            "
                                            :min="
                                                listing.target_completion_datefrom
                                            "
                                            name="target_completion_dateto"
                                            class="mb-1 p-0"
                                            :state="
                                                errors.length > 0 ? false : null
                                            "
                                            disabled
                                        />
                                        <small class="text-danger">{{
                                            errors[0]
                                        }}</small>
                                    </validation-provider>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <h4 class="mb-2 text-primary">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Target Budget - Min and Max
                            </h4>
                            <div class="form-row">
                                <div class="col">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Minimum budget"
                                        rules="required"
                                    >
                                        <b-form-input
                                            v-model="listing.min_budget"
                                            class="mb-1"
                                            placeholder="Minimum Budget"
                                            :state="
                                                errors.length > 0 ? false : null
                                            "
                                            disabled
                                        />
                                        <small class="text-danger">{{
                                            errors[0]
                                        }}</small>
                                    </validation-provider>
                                </div>
                                <div class="col">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Maximum budget"
                                        rules="required"
                                    >
                                        <b-form-input
                                            v-model="listing.max_budget"
                                            placeholder="Maximum Budget"
                                            class="mb-1"
                                            :state="
                                                errors.length > 0 ? false : null
                                            "
                                            disabled
                                        />
                                        <small class="text-danger">{{
                                            errors[0]
                                        }}</small>
                                    </validation-provider>
                                </div>
                            </div>

                            <!-- </b-form> -->
                        </b-col>
                    </b-row>
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
                                            align-items-start
                                            flex-sm-row flex-column flex-wrap
                                            justify-content-between
                                            mb-1 mb-sm-50
                                        "
                                    >
                                        <h6>{{ visit.visit_summary }} - {{ visit.percentage }}%</h6>
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
                            <h4 class="mb-2">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Listing Details
                            </h4>
                            <validation-provider
                                #default="{ errors }"
                                name="Name"
                                rules="required"
                            >
                                <b-form-group
                                    label="Name your listing"
                                    label-for="listingname"
                                >
                                    <b-form-input
                                        id="listingname"
                                        v-model="listing.title"
                                        placeholder="Name"
                                        disabled
                                    />
                                </b-form-group>
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </validation-provider>

                            <div class="mb-2">
                                <label for="listingDetails">Details</label>
                                <b-form-textarea
                                    id="listingDetails"
                                    v-model="listing.description"
                                    placeholder="Listing Details"
                                    rows="3"
                                    disabled
                                />
                            </div>

                            <!-- images -->
                            <div class="d-flex flex-wrap mb-2">
                            <b-img
                                v-for="(image, idx) in listing.images"
                                :key="idx"
                                fluid
                                thumbnail
                                class="w-25"
                                :src="image"
                                v-b-modal.modal-listing-images
                            />
                            <div v-if="!listing.images">No images found</div>
                        </div>
                        <!-- modal -->
                            <b-modal
                            id="modal-listing-images"
                            ok-only
                            centered
                            size="lg"
                            >
                            <swiper
                                class="swiper-navigations"
                                :options="swiperOptions"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            >
                                <swiper-slide
                                v-for="(image, index) in listing.images"
                                :key="index"
                                >
                                <b-img
                                    :src="image"
                                    fluid
                                />
                                </swiper-slide>

                                <!-- Add Arrows -->
                                <div
                                slot="button-next"
                                class="swiper-button-next"
                                />
                                <div
                                slot="button-prev"
                                class="swiper-button-prev"
                                />
                            </swiper>
                            </b-modal>

                            <!-- <b-row>
                                <b-col lg="6" class="mb-2">
                                    <div id="map" class="h-100 mt-2"></div>
                                </b-col>
                                <b-col lg="6">
                                    <b-form-group
                                        label="Address Line 1"
                                        label-for="address-line-1"
                                    >
                                        <b-form-input
                                            v-model="listing.address_line1"
                                            id="address-line-1"
                                            placeholder="Address Line 1"
                                            required
                                            disabled
                                        />
                                    </b-form-group>
                                    <b-form-group
                                        label="Address Line 2"
                                        label-for="address-line-2"
                                    >
                                        <b-form-input
                                            v-model="listing.address_line2"
                                            id="address-line-2"
                                            placeholder="Address Line 2"
                                            disabled
                                        />
                                    </b-form-group>
                                    <b-form-group
                                        label="Country"
                                        label-for="country"
                                    >
                                        <b-form-input
                                            id="country"
                                            placeholder="Country"
                                            required
                                            v-model="listing.country"
                                            disabled
                                        />
                                    </b-form-group>
                                    <b-form-group
                                        label="State"
                                        label-for="state"
                                    >
                                        <b-form-input
                                            v-model="listing.state"
                                            placeholder="State"
                                            id="state"
                                            disabled
                                        />
                                    </b-form-group>
                                    <b-form-group
                                        label="District"
                                        label-for="district"
                                    >
                                        <b-form-input
                                            v-model="listing.district"
                                            placeholder="District"
                                            id="district"
                                            disabled
                                        />
                                    </b-form-group>
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
    },
    data() {
        return {
            progressValue: "40%",
            // map
            latLng: { lat: 20.5937, lng: 78.9629 },

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
        };
    },
    methods: {
        ...mapActions({ loadListingVisits: "listing/loadListingVisits" }),

        changeVisitData( index ) {
            this.activeVisitData = true
            this.listing.images = this.listingVisit[index].images
            this.listing.description = this.listingVisit[index].visit_detail
        },

        // Initialize map
        // initMap() {
        //     let map = new google.maps.Map(document.getElementById("map"), {
        //         center: this.latLng,
        //         zoom: 12,
        //     });
        // },
    },
    computed: {
        ...mapGetters({
            isLoading: "listing/getIsLoading",
        }),
    },
    mounted() {
        // this.initMap();

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
