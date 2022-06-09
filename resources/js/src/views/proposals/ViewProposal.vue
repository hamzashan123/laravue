<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Approve {{ contractor.first_name }}'s proposal on {{ listing.title }}</h1>
                    <b-badge :variant="statuses_color[1][proposal.status]">
                        {{ statuses_color[0][proposal.status] }}
                     </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'proposals.listing', params: { listingId: listing.id } }"
                    >
                        Back to Proposals
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <!-- Date and amount Form -->
        <b-card>
            <b-overlay :show="isDataLoading"  spinner-variant="primary">
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
                                        listing.target_completion_datefrom +
                                        ' - ' +
                                        listing.target_completion_dateto
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
                                        listing.min_budget +
                                        ' - ' +
                                        listing.max_budget
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
                            <div class="form-inline">

                                <b-form-datepicker
                                    placeholder="Select From Date"
                                    id="target_startdate"
                                    class="mb-1 p-0 mr-1"
                                    v-model="proposal.target_startdate"
                                    name="target_startdate"
                                    disabled
                                />
                                <b-form-datepicker
                                    placeholder="Select End Date"
                                    id="target_enddate"
                                    class="mb-1 p-0"
                                    v-model="proposal.target_enddate"
                                    :min="proposal.target_startdate"
                                    name="target_enddate"
                                    disabled
                                />
                            </div>
                            </b-form-group>
                        </b-col>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Budget"
                                label-for="target-budget"
                                label-cols-md="3"
                            >
                            <div class="form-inline">

                                <b-form-input
                                    v-model="proposal.min_budget"
                                    class="mb-1 mr-1"
                                    placeholder="Minimum Budget"
                                    disabled
                                />
                                <b-form-input
                                    v-model="proposal.max_budget"
                                    class="mb-1"
                                    placeholder="Maximum Budget"
                                    disabled
                                />
                            </div>
                            </b-form-group>
                        </b-col>
                    </b-col>
                    <b-col>
                        <div class="text-right">
                            <b-button
                                v-if="can('create', 'all-proposal')"
                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                variant="danger"
                                @click="rejectProposalTrigger"
                            >
                                Reject
                                <b-spinner small v-if="isLoading" />
                            </b-button>
                            <b-button
                                v-if="can('create', 'all-proposal')"
                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                variant="primary"
                                @click="approveProposalTrigger"
                            >
                                Approve
                                <b-spinner small v-if="isLoading" />
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card>

        <!-- Images and Detail -->
        <b-card>
            <b-overlay :show="isDataLoading"  spinner-variant="primary">
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
                            <div v-if="!listing.images">No images found</div>
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
                            Listing Details ( by Client )
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
        BInputGroup,
        BInputGroupPrepend,
        BSpinner,
    },
    data() {
        return {
            proposalId: "",
            listing: {},
            proposal: {},
            contractor: {},
            statuses_color,

            can,
        };
    },
    methods: {
        ...mapActions({ loadProposal: "proposal/loadProposal", approveProposal: 'proposal/approveProposal',  rejectProposal: 'proposal/rejectProposal' }),

        // approve proposal
        approveProposalTrigger() {
            let proposalData = new FormData();
            proposalData.append( "id", this.proposalId );

            this.approveProposal(proposalData)
                .then((response) => {
                    if (response.success) {
                        console.log(response.data);
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
        // reject / deny proposal
        rejectProposalTrigger() {
            let proposalData = new FormData();
            proposalData.append( "id", this.proposalId );

            this.rejectProposal(proposalData)
                .then((response) => {
                    if (response.success) {
                        console.log(response.data);
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
    },
    computed: {
        ...mapGetters({ isLoading: "proposal/getIsLoading", isDataLoading: "proposal/getIsDataLoading" }),
    },
    created() {
        this.proposalId = this.$route.params.proposalId;

        this.loadProposal({ id: this.proposalId })
            .then((response) => {
                console.log(response);
                if (response.success) {
                    this.proposal = response.data;
                    this.listing = response.data.listing;
                    this.contractor = response.data.contractor;
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
