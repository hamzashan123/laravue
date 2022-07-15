<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Contract of {{ listing.title }}</h1>

                    <b-badge :variant="statuses_color[1][listing.status]" v-if="listing.status">
                        {{ statuses_color[0][listing.status] }}
                    </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-if="can('create', 'all-contract') && listing.status == 'contract_started'"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="success"
                        @click="completeContractTrigger"
                    >
                        Complete Contract
                    </b-button>
                    <b-button
                        v-if="can('create', 'all-contract') && listing.status == 'pre_contract'"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="info"
                        @click="startContractTrigger"
                    >
                        Start Contract
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{
                            name: 'contracts.add',
                            params: { listingID: id },
                        }"
                    >
                        Upload Docs
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'contracts' }"
                    >
                        Back
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <!-- Summary -->
        <b-row class="h-100">
            <b-col lg="4" md="6" class="equal">
                <b-card class="bg-lighten-5 border-primary">
                    <div class="mb-1">
                        <b-badge pill variant="primary" class="text-center">
                            <feather-icon
                                icon="UserIcon"
                                size="24"
                                class="text-center"
                            />
                        </b-badge>
                        <b-card-title class="d-inline ml-1">
                            Client's Expectation
                        </b-card-title>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between flex-wrap"
                    >
                        <div class="font-small-5 text-uppercase">Budget</div>
                        <div class="h3">${{ listing.min_budget }} - ${{ listing.max_budget }}</div>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between flex-wrap"
                    >
                        <div class="font-small-5 text-uppercase">
                            Date
                        </div>
                        <div class="h3">{{ listing.target_completion_datefrom }} - {{ listing.target_completion_dateto }}</div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap mt-1">
                        <feather-icon
                            icon="CalendarIcon"
                            size="24"
                            variant="primary"
                            class="text-center text-primary mr-1"
                        />
                        <div class="font-small-4 mr-1 text-danger">{{ new Date(listing.created_at).toDateString() }}</div>
                        <div class="font-small-5 text-uppercase mr-1">
                            Listing Created on
                        </div>
                    </div>
                </b-card>
            </b-col>
            <b-col lg="4" md="6" class="equal">
                <b-card class="bg-lighten-5 border-warning">
                    <div class="mb-1">
                        <b-badge pill variant="warning" class="text-center">
                            <feather-icon
                                icon="ShoppingBagIcon"
                                size="24"
                                class="text-center"
                            />
                        </b-badge>
                        <b-card-title class="d-inline ml-1">
                            Contractor's Estimate
                        </b-card-title>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between flex-wrap"
                    >
                        <div class="font-small-5 text-uppercase">Budget</div>
                        <div class="h3">${{ proposal.min_budget }} - ${{ proposal.max_budget }}</div>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between flex-wrap"
                    >
                        <div class="font-small-5 text-uppercase">
                            Date
                        </div>
                        <div class="h3">{{ proposal.target_startdate }} - {{ proposal.target_enddate }}</div>
                    </div>
                    <div class="d-flex align-items-center flex-wrap mt-1">
                        <feather-icon
                            icon="CalendarIcon"
                            size="24"
                            variant="warning"
                            class="text-center text-warning mr-1"
                        />
                        <div class="font-small-4 mr-1 text-danger">{{ new Date(proposal.created_at).toDateString() }}</div>
                        <div class="font-small-5 text-uppercase mr-1">
                            Proposal Created on
                        </div>
                    </div>
                </b-card>
            </b-col>
            <b-col lg="4" md="6" class="equal">
                <b-card class="bg-lighten-5 border-success">
                    <div class="mb-1">
                        <b-badge pill variant="success" class="text-center">
                            <feather-icon
                                icon="FileTextIcon"
                                size="24"
                                class="text-center"
                            />
                        </b-badge>
                        <b-card-title class="d-inline ml-1">
                            Contract Status
                        </b-card-title>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between flex-wrap mb-1"
                    >
                        <div class="font-small-5 text-uppercase mr-1">Legal</div>
                        <div class="h3">{{ legal_total_percentage }}%</div>
                        <div class="d-flex align-items-center flex-wrap">
                            <feather-icon
                                icon="CalendarIcon"
                                size="24"
                                variant="success"
                                class="text-center text-success mr-1"
                            />
                            <div class="font-small-4 mr-1 text-danger">{{ new Date(legal_client_last_update_on).toDateString() }}</div>
                            <div class="font-small-5 text-uppercase mr-1">
                                Last updated on
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex align-items-center justify-content-between flex-wrap"
                    >
                        <div class="font-small-5 text-uppercase mr-1">Payment</div>
                        <div class="h3">{{ finance_total_percentage }}%</div>
                        <div class="d-flex align-items-center flex-wrap">
                            <feather-icon
                                icon="CalendarIcon"
                                size="24"
                                variant="success"
                                class="text-center text-success mr-1"
                            />
                            <div class="font-small-4 mr-1 text-danger">{{ new Date(finance_client_last_update_on).toDateString() }}</div>
                            <div class="font-small-5 text-uppercase mr-1">
                                Last update on
                            </div>
                        </div>
                    </div>
                    <!-- <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="success"
                        block
                        :to="{
                            name: 'contracts.view',
                            params: { listingID: id },
                        }"
                    >
                        View Details
                    </b-button> -->
                </b-card>
            </b-col>
        </b-row>

        <!-- Date and amount Form -->
        <b-form @submit.prevent enctype="multipart/form-data">
            <validation-observer ref="validationRules">

                <!-- Images and Detail -->
                <b-card>
                    <b-row>
                        <!-- Visting detail -->
                        <b-col md="6" class="mb-2">
                            <b-tabs>
                                <b-tab active>
                                    <template #title>
                                        <feather-icon icon="HomeIcon" />
                                        <span>Client</span>
                                    </template>
                                    <div>
                                        <b-form-group
                                            label-for="client_options"
                                        >
                                            <b-form-radio-group
                                                v-model="selectedClientTab"
                                                :options="client_options"
                                                class="mt-2 mb-2"
                                                name="client_options"
                                            >
                                            </b-form-radio-group>
                                        </b-form-group>
                                        <b-row v-if="selectedClientTab == 'legal'">
                                            <!-- timeline -->
                                            <b-col md="12" class="mb-2">

                                                <app-timeline>
                                                    <app-timeline-item
                                                        variant="secondary"
                                                        v-for="(
                                                            docDetails,
                                                            index
                                                        ) in legal_client_documents"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="d-flex align-items-start flex-sm-row flex-column flex-wrap justify-content-between mb-1 mb-sm-50"
                                                        >
                                                            <h6>
                                                                {{
                                                                    docDetails.notes
                                                                }}
                                                                -
                                                                {{
                                                                    docDetails.percentage
                                                                }}%
                                                            </h6>
                                                            <b-button
                                                                v-ripple.400="
                                                                    'rgba(113, 102, 240, 0.15)'
                                                                "
                                                                variant="outline-primary"
                                                                @click="
                                                                    changeDocsData(
                                                                        docDetails.documents
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="align-middle"
                                                                    >{{
                                                                        new Date(docDetails.created_at).toDateString()
                                                                    }}</span
                                                                >
                                                                <feather-icon
                                                                    icon="CalendarIcon"
                                                                    class="mr-50"
                                                                />
                                                            </b-button>
                                                        </div>
                                                        <div
                                                            class="progress-wrapper"
                                                        >
                                                            <b-progress
                                                                :value="
                                                                    docDetails.percentage
                                                                "
                                                                max="100"
                                                                show-value
                                                                height="20px"
                                                            />
                                                        </div>
                                                    </app-timeline-item>
                                                </app-timeline>
                                            </b-col>
                                        </b-row>

                                        <b-row v-if="selectedClientTab == 'payment'">
                                            <!-- timeline -->
                                            <b-col md="12" class="mb-2">

                                                <app-timeline>
                                                    <app-timeline-item
                                                        variant="secondary"
                                                        v-for="(
                                                            docDetails,
                                                            index
                                                        ) in finance_client_documents"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="d-flex align-items-start flex-sm-row flex-column flex-wrap justify-content-between mb-1 mb-sm-50"
                                                        >
                                                            <h6>
                                                                {{
                                                                    docDetails.notes
                                                                }}
                                                                -
                                                                {{
                                                                    docDetails.percentage
                                                                }}%
                                                            </h6>
                                                            <b-button
                                                                v-ripple.400="
                                                                    'rgba(113, 102, 240, 0.15)'
                                                                "
                                                                variant="outline-primary"
                                                                @click="
                                                                    changeDocsData(
                                                                        docDetails.documents
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="align-middle"
                                                                    >{{
                                                                        new Date(docDetails.created_at).toDateString()
                                                                    }}</span
                                                                >
                                                                <feather-icon
                                                                    icon="CalendarIcon"
                                                                    class="mr-50"
                                                                />
                                                            </b-button>
                                                        </div>
                                                        <div
                                                            class="progress-wrapper"
                                                        >
                                                            <b-progress
                                                                :value="
                                                                    docDetails.percentage
                                                                "
                                                                max="100"
                                                                show-value
                                                                height="20px"
                                                            />
                                                        </div>
                                                    </app-timeline-item>
                                                </app-timeline>
                                            </b-col>
                                        </b-row>
                                    </div>
                                </b-tab>
                                <b-tab>
                                    <template #title>
                                        <feather-icon icon="HomeIcon" />
                                        <span>Contractor</span>
                                    </template>
                                    <div>
                                         <b-form-group
                                            label-for="contractor_options"
                                        >
                                            <b-form-radio-group
                                                v-model="selectedContractorTab"
                                                :options="contractor_options"
                                                class="mt-2 mb-2"
                                                name="contractor_options"
                                            >
                                            </b-form-radio-group>
                                        </b-form-group>

                                        <b-row v-if="selectedContractorTab == 'legal'">

                                            <!-- timeline -->
                                            <b-col md="12" class="mb-2">

                                                <app-timeline>
                                                    <app-timeline-item
                                                        variant="secondary"
                                                        v-for="(
                                                            docDetails,
                                                            index
                                                        ) in legal_contractor_documents"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="d-flex align-items-start flex-sm-row flex-column flex-wrap justify-content-between mb-1 mb-sm-50"
                                                        >
                                                            <h6>
                                                                {{
                                                                    docDetails.notes
                                                                }}
                                                                -
                                                                {{
                                                                    docDetails.percentage
                                                                }}%
                                                            </h6>
                                                            <b-button
                                                                v-ripple.400="
                                                                    'rgba(113, 102, 240, 0.15)'
                                                                "
                                                                variant="outline-primary"
                                                                @click="
                                                                    changeDocsData(
                                                                        docDetails.documents
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="align-middle"
                                                                    >{{
                                                                        new Date(docDetails.created_at).toDateString()
                                                                    }}</span
                                                                >
                                                                <feather-icon
                                                                    icon="CalendarIcon"
                                                                    class="mr-50"
                                                                />
                                                            </b-button>
                                                        </div>
                                                        <div
                                                            class="progress-wrapper"
                                                        >
                                                            <b-progress
                                                                :value="
                                                                    docDetails.percentage
                                                                "
                                                                max="100"
                                                                show-value
                                                                height="20px"
                                                            />
                                                        </div>
                                                    </app-timeline-item>
                                                </app-timeline>
                                            </b-col>
                                        </b-row>

                                        <b-row v-if="selectedContractorTab == 'payment'">
                                            <!-- timeline -->
                                            <b-col md="12" class="mb-2">

                                                <app-timeline>
                                                    <app-timeline-item
                                                        variant="secondary"
                                                        v-for="(
                                                            docDetails,
                                                            index
                                                        ) in finance_contractor_documents"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="d-flex align-items-start flex-sm-row flex-column flex-wrap justify-content-between mb-1 mb-sm-50"
                                                        >
                                                            <h6>
                                                                {{
                                                                    docDetails.notes
                                                                }}
                                                                -
                                                                {{
                                                                    docDetails.percentage
                                                                }}%
                                                            </h6>
                                                            <b-button
                                                                v-ripple.400="
                                                                    'rgba(113, 102, 240, 0.15)'
                                                                "
                                                                variant="outline-primary"
                                                                @click="
                                                                    changeDocsData(
                                                                        docDetails.documents
                                                                    )
                                                                "
                                                            >
                                                                <span
                                                                    class="align-middle"
                                                                    >{{
                                                                        new Date(docDetails.created_at).toDateString()
                                                                    }}</span
                                                                >
                                                                <feather-icon
                                                                    icon="CalendarIcon"
                                                                    class="mr-50"
                                                                />
                                                            </b-button>
                                                        </div>
                                                        <div
                                                            class="progress-wrapper"
                                                        >
                                                            <b-progress
                                                                :value="
                                                                    docDetails.percentage
                                                                "
                                                                max="100"
                                                                show-value
                                                                height="20px"
                                                            />
                                                        </div>
                                                    </app-timeline-item>
                                                </app-timeline>
                                            </b-col>
                                        </b-row>
                                    </div>
                                </b-tab>
                            </b-tabs>
                        </b-col>
                        <!-- Details Form -->
                        <b-col md="6" class="mb-2">
                            <show-title-description heading="Listing Details" :listing="listing" />

                            <!-- images -->
                            <div v-if="!isShowingDocuments">
                                <show-images-slider :listing="listing" />
                            </div>
                            <!-- Documents -->
                            <div v-if="isShowingDocuments">
                                <show-documents :documents="showingCurrentDocs" />
                            </div>

                            <b-row>
                                <b-col lg="6" class="mb-2">
                                    <show-map lat=20.5937 lng=78.9629 />
                                </b-col>
                                <b-col lg="6">
                                    <show-address :listing="listing"/>
                                </b-col>
                            </b-row>

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
    BCardTitle,
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
    BTabs,
    BTab,
    BAvatar,
    BFormRadioGroup,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import AppTimeline from "@core/components/app-timeline/AppTimeline.vue";
import AppTimelineItem from "@core/components/app-timeline/AppTimelineItem.vue";
import { mapActions, mapGetters } from "vuex";
import { required } from "@validations";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { statuses_color } from "@/fieldsdata/index.js";
import { Swiper, SwiperSlide } from "vue-awesome-swiper";
import "swiper/css/swiper.css";
import { can } from "@/auth/authentication.js";
import ShowMap from "@/components/ShowMap.vue";
import ShowTitleDescription from '@/components/ShowTitleDescription.vue'
import ShowAddress from '@/components/ShowAddress.vue'
import ShowImagesSlider from '@/components/ShowImagesSlider.vue'
import ShowDocuments from '@/components/ShowDocuments.vue'

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
        BRow,
        BCol,
        BCard,
        BButton,
        BCardTitle,
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
        BTabs,
        BTab,
        BAvatar,
        BFormRadioGroup,

        ShowMap,
        ShowTitleDescription,
        ShowAddress,
        ShowImagesSlider,
        ShowDocuments,
    },
    data() {
        return {
            selectedContractorTab: 'legal',
            selectedClientTab: 'legal',

            contractDetails: {},
            legal_client_documents: {},
            legal_contractor_documents: {},
            finance_client_documents: {},
            finance_contractor_documents: {},
            legal_client_total_percentage: 0,
            legal_contractor_total_percentage: 0,
            finance_client_total_percentage: 0,
            finance_contractor_total_percentage: 0,
            legal_total_percentage:0,
            finance_total_percentage:0,

            finance_client_last_update_on: '',
            legal_client_last_update_on: '',

            isShowingDocuments: false,
            showingCurrentDocs: {},

            swiperOptions: {
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            },
            // listing
            id: "",
            listing: {},
            proposal: {},
            contract: {},
            contractor: {},
            //   Validation
            required,
            activeVisitData: false,
            statuses_color,

            can,

            client_options: [
                { text: "Legal", value: "legal" },
                { text: "Payment", value: "payment" },
            ],
            contractor_options: [
                { text: "Legal", value: "legal" },
                { text: "Payment", value: "payment" },
            ],
        };
    },
    methods: {
        ...mapActions({ loadContractDetails: "contract/loadContractDetails", startContract: 'contract/startContract', completeContract: 'contract/completeContract' }),

        changeDocsData(documents) {
            this.isShowingDocuments = true;
            this.showingCurrentDocs = documents;
        },

        // start contract
        startContractTrigger() {
            let formData = new FormData();
            formData.append("listing_id", this.id);
            formData.append("contractor_id", this.contractor.id);

            this.startContract(formData)
                .then((response) => {
                    if (response.success) {
                        this.listing.status = response.data.status
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
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

        // complete contract
        completeContractTrigger() {
            let formData = new FormData();
            formData.append("listing_id", this.id);
            formData.append("contractor_id", this.contractor.id);

            this.completeContract(formData)
                .then((response) => {
                    if (response.success) {
                        this.listing.status = response.data.status
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
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
    },
    computed: {
        ...mapGetters({
            isLoading: "contract/getIsLoading",
        }),
    },
    mounted() {
        this.id = this.$route.params.listingId;

        this.loadContractDetails({ listing_id: this.id })
            .then((response) => {
                if (response.success) {
                    this.listing = response.data[0].listing;
                    this.proposal = response.data[0].proposal;
                    this.contract = response.data[0].contract;
                    this.contractor = response.data[0].proposal.contractor;

                    this.finance_client_documents =
                        response.data[0].finance_client_documents;
                    this.finance_contractor_documents =
                        response.data[0].finance_contractor_documents;
                    this.legal_client_documents =
                        response.data[0].legal_client_documents;
                    this.legal_contractor_documents =
                        response.data[0].legal_contractor_documents;
                    this.finance_client_total_percentage =
                        response.data[0].finance_client_total_percentage;
                    this.legal_client_total_percentage =
                        response.data[0].legal_client_total_percentage;
                    this.finance_contractor_total_percentage =
                        response.data[0].finance_contractor_total_percentage;
                    this.legal_contractor_total_percentage =
                        response.data[0].legal_contractor_total_percentage;
                    this.legal_total_percentage =
                        response.data[0].legal_total_percentage;
                    this.finance_total_percentage =
                        response.data[0].finance_total_percentage;

                    this.finance_client_last_update_on = response.data[0].finance_client_last_update_on;
                    this.legal_client_last_update_on = response.data[0].legal_client_last_update_on;

                    console.log(response);
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
            })

    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
