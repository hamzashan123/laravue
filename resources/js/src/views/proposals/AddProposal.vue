<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Send your proposal to {{ listing.title }}</h1>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'listings.view', params: { listingId: listing.id } }"
                    >
                        Back
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <!-- Date and amount Form -->
        <b-card>
            <b-overlay :show="isLoading" spinner-variant="primary">
                <b-row>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Client Target Date and Budget
                        </h4>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Date"
                                label-for="target-date"
                                label-cols-md="3"
                            >
                                <b-form-input
                                    id="target-date"
                                    placeholder="Target Date"
                                    :value="
                                       ' Start:  ' + listing.target_completion_datefrom +
                                        '  -  ' +
                                        ' End :  ' + listing.target_completion_dateto
                                    "
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Budget"
                                label-for="target-budget"
                                label-cols-md="3"
                            >
                                <b-form-input
                                    id="target-budget"
                                    placeholder="Target Budget"
                                    :value="
                                        ' Min:  ' + listing.min_budget +
                                        '  -  ' +
                                        ' Max:  ' + listing.max_budget
                                    "
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                    </b-col>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Contractor Target Date and Budget
                        </h4>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Date"
                                label-for="target-date"
                                label-cols-md="3"
                            >

                            <div class="form-row">
                                <div class="col p-0 mr-1">
                                    <b-form-datepicker
                                        placeholder="Select From Date"
                                        id="target_startdate"
                                        class=" p-0 overflow-hiden"
                                        v-model="proposal.target_startdate"
                                        name="target_startdate"
                                    />
                                </div>
                                <div class="col p-0">
                                    <b-form-datepicker
                                        placeholder="Select End Date"
                                        id="target_enddate"
                                        class=" p-0"
                                        v-model="proposal.target_enddate"
                                        :min="proposal.target_startdate"
                                        name="target_enddate"
                                    />
                                </div>
                            </div>
                            </b-form-group>

                        </b-col>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Budget"
                                label-for="target-budget"
                                label-cols-md="3"
                            >
                            <div class="form-row">
                                <div class="col p-0 mr-1">
                                    <b-form-input
                                    v-model="proposal.min_budget"
                                    class="mb-1 mr-1"
                                    placeholder="Minimum Budget"
                                />
                                </div>
                                <div class="col p-0">
                                    <b-form-input
                                    v-model="proposal.max_budget"
                                    class="mb-1"
                                    placeholder="Maximum Budget"
                                />
                                </div>
                            </div>
                            </b-form-group>
                        </b-col>
                    </b-col>
                    <b-col>
                        <div class="text-right">
                            <b-button
                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                variant="primary"
                                @click="sendProposalTrigger"
                            >
                                Send Proposal
                                <b-spinner small v-if="isLoading" />
                            </b-button>
                        </div>
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
                            Listing Details by Client
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
                                <show-map lat=20.5937 lng=78.9629 />
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
    BInputGroup,
    BInputGroupPrepend,
    BSpinner,
} from "bootstrap-vue";
import ShowMap from '@/components/ShowMap.vue'
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
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
        BInputGroup,
        BInputGroupPrepend,
        BSpinner,
        Swiper,
        SwiperSlide,

        ShowMap,
    },
    data() {
        return {
            listingId: "",
            listing: {},
            proposal: {},
            statuses_color,

            swiperOptions: {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
                },
            },
        };
    },
    methods: {
        ...mapActions({ loadListing: "listing/loadListing", sendProposal: 'proposal/sendProposal' }),

        // publish listing
        sendProposalTrigger() {
            let proposalData = new FormData();
            proposalData.append( "listing_id", this.listingId );
            proposalData.append( "min_budget", this.proposal.min_budget );
            proposalData.append( "max_budget", this.proposal.max_budget );
            proposalData.append( "target_startdate", this.proposal.target_startdate );
            proposalData.append( "target_enddate", this.proposal.target_enddate );

            this.sendProposal(proposalData)
                .then((response) => {
                    if (response.success) {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
                        this.$router.push({ name: 'proposals' })
                    } else {
                        console.log(response);
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
                            title: "Error While sending!",
                            icon: "EditIcon",
                            variant: "danger",
                        },
                    });
                });
        },

        // Initialize map
        initMap() {
            let map = new google.maps.Map(document.getElementById("map"), {
                center: this.latLng,
                zoom: 12,
            });
        }

    },
    computed: {
        ...mapGetters({ isLoading: "listing/getIsLoading"  }),
    },
    created() {
        this.listingId = this.$route.params.listingId;

        const getUser = JSON.parse(localStorage.getItem("userData")) || ''
        const user_Role = getUser.user_role || '';
        const userRoleID = user_Role.id || ''


        this.loadListing({ id: this.listingId, role_id: userRoleID })
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
