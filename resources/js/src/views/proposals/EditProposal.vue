<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12" class="mb-2">
                <b-card-text>
                    <h1>Edit your proposal on {{ listing.title }}</h1>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                       v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
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
                        <validation-observer ref="validationRules">
                        <b-form>
                            <b-col cols="12">
                                <b-form-group
                                    label="Target Date"
                                    label-for="target-date"
                                    label-cols-md="3"
                                >

                                <div class="form-row">
                                    <div class="col p-0 mr-1">
                                        <validation-provider
                                            #default="{ errors }"
                                            name="From Date"
                                            rules="required"
                                        >
                                        <b-form-datepicker
                                            placeholder="From Date"
                                            id="target_startdate"
                                            class=" p-0 overflow-hiden"
                                            v-model="proposal.target_startdate"
                                            name="target_startdate"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                        </validation-provider>
                                    </div>
                                    <div class="col p-0">
                                        <validation-provider
                                            #default="{ errors }"
                                            name="End Date"
                                            rules="required"
                                        >
                                        <b-form-datepicker
                                            placeholder="End Date"
                                            id="target_enddate"
                                            class=" p-0"
                                            v-model="proposal.target_enddate"
                                            :min="proposal.target_startdate"
                                            name="target_enddate"
                                            :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                        </validation-provider>
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
                                        <validation-provider
                                            #default="{ errors }"
                                            vid="min_budget"
                                            name="Min Budget"
                                            rules="required"
                                        >
                                        <b-form-input
                                        v-model="proposal.min_budget"
                                        class="mb-1 mr-1"
                                        placeholder="Minimum Budget"
                                        :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                        </validation-provider>
                                    </div>
                                    <div class="col p-0">
                                        <validation-provider
                                            #default="{ errors }"
                                            vid="max_budget"
                                            name="Max Budget"
                                            rules="required|minVal:@min_budget"
                                        >
                                        <b-form-input
                                        v-model="proposal.max_budget"
                                        class="mb-1"
                                        placeholder="Maximum Budget"
                                        :state="errors.length > 0 ? false:null"
                                        />
                                        <small class="text-danger">{{ errors[0] }}</small>
                                        </validation-provider>
                                    </div>
                                </div>
                                </b-form-group>
                            </b-col>
                        </b-form>
                        </validation-observer>
                    </b-col>
                    <b-col>
                        <div class="text-right">
                            <b-button
                                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
                                variant="primary"
                                @click="updateProposalTrigger"
                            >
                                Update Proposal
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
    BInputGroup,
    BInputGroupPrepend,
    BSpinner,
} from "bootstrap-vue";
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate'
import { required } from '@validations'
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { Swiper, SwiperSlide } from 'vue-awesome-swiper'
import 'swiper/css/swiper.css'
import ShowMap from '@/components/ShowMap.vue'
import ShowTitleDescription from '@/components/ShowTitleDescription.vue'
import ShowAddress from '@/components/ShowAddress.vue'
import ShowImagesSlider from '@/components/ShowImagesSlider.vue'

extend('minVal', {
  params: ['target'],
  validate(value, { target }) {
    return parseInt(value)  > parseInt(target);
  },
  message: 'The {_field_} should be greater then {target}'
});

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
        // validations
        ValidationProvider,
        ValidationObserver,

        ShowMap,
        ShowTitleDescription,
        ShowAddress,
        ShowImagesSlider,
    },
    data() {
        return {
            proposalId: '',
            listing: {},
            proposal: {},
            statuses_color,

            swiperOptions: {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
                },
            },
            // validation
            required,
        };
    },
    methods: {
        ...mapActions({ loadProposal: "proposal/loadProposal", updateProposal: 'proposal/updateProposal' }),

        // publish listing
        updateProposalTrigger() {
            this.$refs.validationRules.validate().then(success => {
                if (success) {
                let proposalData = new FormData();
                proposalData.append( "proposal_id", this.proposalId );
                proposalData.append( "min_budget", this.proposal.min_budget );
                proposalData.append( "max_budget", this.proposal.max_budget );
                proposalData.append( "target_startdate", this.proposal.target_startdate );
                proposalData.append( "target_enddate", this.proposal.target_enddate );

                this.updateProposal(proposalData)
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
                            this.$router.push({ name: 'proposals.view', params: { proposalId: this.proposalId } })
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

                }
            })
        },

    },
    computed: {
        ...mapGetters({ isLoading: "listing/getIsLoading"  }),
    },
    created() {
        this.proposalId = this.$route.params.proposalId;

        this.loadProposal({ id: this.proposalId })
            .then((response) => {
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
