<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1> {{ listing.title }} </h1>
                    <b-badge :variant="statuses_color[1][listing.status]">
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
                        v-if="listing.status === 'publish'"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'proposals.add', params: { listingId: id } }"
                    >
                        Send Proposal
                    </b-button>

                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'listings.add-more' }"
                    >
                        Add More data
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="light"
                        :to="{ name: 'listings.detail' }"
                    >
                        See Latest Details
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <b-card>
            <b-overlay :show="isLoading" rounded="sm">
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
            <b-overlay :show="isLoading" rounded="sm">
                <b-row>
                    <!-- Images -->
                    <b-col md="6" class="mb-2">
                        <div class="d-flex flex-wrap mb-2">
                            <b-img
                                v-for="(image, idx) in listing.images"
                                :key="idx"
                                thumbnail
                                class="w-25"
                                :src="image.image"
                            />
                        </div>
                    </b-col>
                    <!-- Details Form -->
                    <b-col md="6" class="mb-2">
                        <h4 class="mb-2">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Listing Details ( Please enter as mush as possible )
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
                                <b-form-input
                                    id="gmap-autocompelte"
                                    placeholder="Search Address"
                                    disabled
                                />
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6999.66461408364!2d76.92634623988648!3d28.69466251428776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d096a6dcc31c7%3A0xbbcc18016f20e440!2sModicare%20Store!5e0!3m2!1sen!2s!4v1652653238809!5m2!1sen!2s"
                                    width="100%"
                                    height="300"
                                    style="border: 0"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

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
    },
    data() {
        return {
            id: "",
            listing: {},
            statuses_color,
            draftListingId: '',
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
                                console.log(response.data);
                                this.draftListingId = response.data.id
                                this.$toast({
                                    component: ToastificationContent,
                                    props: { title: response.message, icon: "EditIcon", variant: "success" },
                                });
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
        this.id = this.$route.params.id;

        this.loadListing({ id: this.id, role_id: 3 })
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
