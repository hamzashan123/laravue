<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1> {{ listing.title }} </h1>
                    <b-badge :variant="statuses_color[1][listing.status]" v-if="listing.status">
                        {{ statuses_color[0][listing.status] }}
                     </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">

                    <b-button
                        v-if="listing.status === 'draft'"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        @click="publishListingTrigger"
                    >
                        Publish Listing
                    </b-button>

                    <b-button
                        v-if=" ( listing.status === 'publish' && can('create', 'proposal') ) || (listing.status === 'publish' && can('create', 'all-proposal') )"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'proposals.add', params: { listingId: id } }"
                    >
                        Send Proposal
                    </b-button>

                    <b-button
                        v-if="can('update', 'all-visit')"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'listings.add-visits', params:{ listingId: id } }"
                    >
                        Add Visits
                    </b-button>
                    <b-button
                        v-if="( listing.status === 'pre_contract' && can('create', 'listing') ) || (listing.status === 'pre_contract' && can('create', 'all-listing') )"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'listings.detail', params:{ listingId: id } }"
                    >
                        See Latest Updates
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <b-card>
            <b-overlay :show="isLoading" spinner-variant="primary">
                <b-row>
                    <!-- <b-col lg="12" > -->
                        <!-- <div class="text-right">
                            <b-button
                            v-if="can('update', 'listing') || can('update', 'all-listing')"
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            :to="{ name: 'listings.edit', params: { listingId: id } }"
                        >
                            Edit
                            </b-button>
                        </div> -->
                    <!-- </b-col> -->
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
                                <b-form-input
                                    v-model="listing.target_completion_datefrom"
                                    id="target_completion_datefrom"
                                    placeholder="From Date"
                                    disabled
                                />
                            </div>
                            <div class="col">
                                <b-form-input
                                    v-model="listing.target_completion_dateto"
                                    id="target_completion_dateto"
                                    placeholder="Date To"
                                    disabled
                                />
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
                                <b-form-input
                                    v-model="listing.min_budget"
                                    id="min_budget"
                                    placeholder="Minimum Budget"
                                    disabled
                                />
                            </div>
                            <div class="col">
                                <b-form-input
                                    v-model="listing.max_budget"
                                    id="max_budget"
                                    placeholder="Maximum Budget"
                                    disabled
                                />
                            </div>
                        </div>

                        <!-- </b-form> -->
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card>

        <!-- Images and Detail -->
        <b-card>
            <b-overlay :show="isLoading" spinner-variant="primary">
                <b-row>
                    <!-- Images -->
                    <b-col md="6" class="mb-2">
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

                        <div class="mb-2">
                            <label for="listingDetails">Description</label>
                            <b-form-textarea
                                id="listingDetails"
                                v-model="listing.description"
                                placeholder="Listing Details"
                                rows="3"
                                disabled
                            />
                        </div>
                        <b-row>
                            <b-col lg="6" class="mb-2">
                                <div id="map" class="h-100 mt-2"></div>
                            </b-col>
                            <b-col lg="6">
                                <b-form-group
                                    label="Address Line 1 *"
                                    label-for="address-line-1"
                                >
                                    <b-form-input
                                        v-model="listing.address_line1"
                                        id="address-line-1"
                                        placeholder="Address Line 1 *"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Address Line 2 *"
                                    label-for="address-line-2"
                                >
                                    <b-form-input
                                        v-model="listing.address_line2"
                                        id="address-line-2"
                                        placeholder="Address Line 2 *"
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
                                        v-model="listing.country"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group label="State" label-for="state">
                                    <b-form-input
                                        placeholder="State"
                                        v-model="listing.state"
                                        id="state"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="District"
                                    label-for="district"
                                >
                                    <b-form-input
                                        placeholder="District"
                                        v-model="listing.district"
                                        id="district"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <!-- Save -->
                        <!-- <b-col class="text-right">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            type="submit"
                            variant="primary"
                            @click.prevent="saveListingTrigger"
                        >
                            Save Details
                            <b-spinner small v-if="isLoading" />
                        </b-button>
                    </b-col> -->
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card>
    </div>
</template>

<script>
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
    BOverlay,
    BBadge,
    BModal,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { can } from '@/auth/authentication.js'
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'

export default {
    components: {
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
        BOverlay,
        BBadge,
        BModal,
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            id: "",
            listing: {},
            statuses_color,
            draftListingId: '',
            can,

            latLng: { lat: 20.5937, lng: 78.9629 },
            swiperOptions: {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
                },
            },
        };
    },
    methods: {
        ...mapActions({ loadListing: "listing/loadListing", publishLising: 'listing/publishLising' }),

        publishListingTrigger() {
            let listingData = new FormData();
            listingData.append("id", this.id );
            this.publishLising( listingData )
                .then((response) => {
                    if (response.success) {
                        this.listing.status = response.data.status
                        this.$toast({
                            component: ToastificationContent,
                            props: { title: response.message, icon: "EditIcon", variant: "success" },
                        });

                        this.$router.push({ name: 'listings' })
                    } else {
                        console.log(response);
                        this.$toast({
                            component: ToastificationContent,
                            props: { title: response.message,icon: "EditIcon",variant: "danger" },
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast({
                        component: ToastificationContent,
                        props: { title: "Error While Adding!", icon: "EditIcon", variant: "danger" },
                    });
                });
        },

        // Initialize map
        initMap() {
            let map = new google.maps.Map(document.getElementById("map"), {
                center: this.latLng,
                zoom: 12,
            });

            //  var geocoder = new google.maps.Geocoder();
            // geocoder.geocode({ 'address': "Navale Bridge, Maharashtra," }, function (results, status) {
            //     if (status == google.maps.GeocoderStatus.OK) {
            //         map.setCenter(results[0].geometry.location);
            //         var marker = new google.maps.Marker({
            //             map: map,
            //             position: results[0].geometry.location,
            //         });
            //     } else
            //       alert("Problem with geolocation");

            // });
        }
    },
    computed: {
        ...mapGetters({ isLoading: "listing/getIsLoading" }),
    },
    created() {
        this.id = this.$route.params.listingId;

        const getUser = JSON.parse(localStorage.getItem("userData")) || ''
        const user_Role = getUser.user_role || '';
        const userRoleID = user_Role.id || ''

        this.loadListing({ id: this.id, role_id: userRoleID})
            .then((response) => {
                if (response.success) {
                    this.listing = response.data[0];
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
    mounted() {
        this.initMap()
    },
    directives: {
        Ripple,
    },
};
</script>

<style>
</style>
