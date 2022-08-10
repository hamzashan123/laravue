<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12" class="mb-2">
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
                        class="mb-1"
                        variant="primary"
                        @click="publishListingTrigger"
                    >
                        Publish Listing
                    </b-button>

                    <b-button
                        v-if=" ( (listing.status === 'publish' || listing.status === 'waiting_assignment') && can('create', 'proposal') ) || ( ( listing.status === 'publish' || listing.status === 'waiting_assignment' )  && can('create', 'all-proposal') )"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
                        variant="primary"
                        :to="{ name: 'proposals.add', params: { listingId: id } }"
                    >
                        Send Proposal
                    </b-button>

                    <b-button
                        v-if="listing.status === 'contract_started' && can('update', 'all-visit')"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
                        variant="success"
                        :to="{ name: 'listings.add-visits', params:{ listingId: id } }"
                    >
                        Add Visits
                    </b-button>
                    <b-button
                        v-if="( listing.status === 'contract_started' && can('create', 'listing') ) || (listing.status === 'contract_started' && can('create', 'all-listing') )"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
                        variant="primary"
                        :to="{ name: 'listings.visit', params:{ listingId: id } }"
                    >
                        Visits Updates
                    </b-button>
                     <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
                        variant="secondary"
                        :to="{ name: 'listings'}"
                    >
                        Back
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <b-card>
            <b-overlay :show="isLoading" spinner-variant="primary">
                <show-client-date-budget :listing="listing" />
            </b-overlay>
        </b-card>

        <!-- Images and Detail -->
        <b-card>
            <b-overlay :show="isLoading" spinner-variant="primary">
                <b-row>
                    <!-- Images -->
                    <b-col md="6" class="mb-2">
                        <show-images-slider :listing="listing" />
                    </b-col>
                    <!-- Details Form -->
                    <b-col md="6" class="mb-2">
                        <show-title-description heading="Listing Details" :listing="listing" />
                        <b-row>
                            <b-col lg="6" class="mb-2">
                                <show-map :lat="listing.latitude" :lng="listing.longitude" />
                            </b-col>
                            <b-col lg="6">
                                <show-address :listing="listing"/>
                            </b-col>
                        </b-row>
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
    // BModal,
} from "bootstrap-vue";
import ShowMap from '@/components/ShowMap.vue'
import ShowTitleDescription from '@/components/ShowTitleDescription.vue'
import ShowAddress from '@/components/ShowAddress.vue'
import ShowImagesSlider from '@/components/ShowImagesSlider.vue'
import ShowClientDateBudget from '@/components/ShowClientDateBudget.vue'
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { can } from '@/auth/authentication.js'


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
        // BModal,
        // Swiper,
        // SwiperSlide,

        ShowMap,
        ShowTitleDescription,
        ShowAddress,
        ShowImagesSlider,
        ShowClientDateBudget
    },
    data() {
        return {
            id: "",
            listing: {},
            statuses_color,
            draftListingId: '',
            can,
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
    directives: {
        Ripple,
    },
};
</script>

<style>
</style>
