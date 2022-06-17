<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Contract updates on {{ listing.title }}</h1>

                    <b-badge :variant="statuses_color[1][listing.status]">
                        {{ statuses_color[0][listing.status] }}
                    </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-if="can('create', 'all-contract')"
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="success"

                    >
                        Start Contract
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'contracts.add', params: { listingID: id } }"
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
<b-row>
            <b-col md="4" >
                <b-card class="bg-primary bg-lighten-5">
                    <b-row>
                        <b-col cols="6">
                            <b-card-title class="mb-1"> Clients Expectation </b-card-title>
                            <div class="font-small-2">This Month</div>
                            <h5 class="mb-1">$4055.56</h5>
                            <b-card-text class="text-muted font-small-2">
                                <span class="font-weight-bolder">68.2%</span
                                ><span> more earnings than last month.</span>
                            </b-card-text>
                        </b-col>
                        <b-col cols="6">
                            <b-card-title class="mb-1"> Earnings </b-card-title>
                            <div class="font-small-2">This Month</div>
                            <h5 class="mb-1">$4055.56</h5>
                            <b-card-text class="text-muted font-small-2">
                                <span class="font-weight-bolder">68.2%</span
                                ><span> more earnings than last month.</span>
                            </b-card-text>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
            <b-col md="4">
                <b-card class="bg-danger bg-lighten-5">
                    <b-row>
                        <b-col cols="6">
                            <b-card-title class="mb-1"> Contractor Estimates </b-card-title>
                            <div class="font-small-2">This Month</div>
                            <h5 class="mb-1">$4055.56</h5>
                            <b-card-text class="text-muted font-small-2">
                                <span class="font-weight-bolder">68.2%</span
                                ><span> more earnings than last month.</span>
                            </b-card-text>
                        </b-col>
                        <b-col cols="6">
                            <b-card-title class="mb-1"> Contract Status </b-card-title>
                            <div class="font-small-2">This Month</div>
                            <h5 class="mb-1">$4055.56</h5>
                            <b-card-text class="text-muted font-small-2">
                                <span class="font-weight-bolder">68.2%</span
                                ><span> more earnings than last month.</span>
                            </b-card-text>
                        </b-col>
                    </b-row>
                </b-card>
            </b-col>
            <b-col md="4">
                <b-card class="bg-success bg-lighten-5">
                    <b-row>
                        <b-col cols="6">
                            <b-card-title class="mb-1"> Contract Status </b-card-title>
                            <div class="font-small-2">This Month</div>
                            <h5 class="mb-1">$4055.56</h5>
                            <b-card-text class="text-muted font-small-2">
                                <span class="font-weight-bolder">68.2%</span
                                ><span> more earnings than last month.</span>
                            </b-card-text>
                        </b-col>
                        <b-col cols="6">
                            <b-card-title class="mb-1"> Earnings </b-card-title>
                            <div class="font-small-2">This Month</div>
                            <h5 class="mb-1">$4055.56</h5>
                            <b-card-text class="text-muted font-small-2">
                                <span class="font-weight-bolder">68.2%</span
                                ><span> more earnings than last month.</span>
                            </b-card-text>
                        </b-col>
                    </b-row>
                </b-card>
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
                        <b-tabs>
                            <b-tab active>
                                <template #title>
                                    <feather-icon icon="HomeIcon" />
                                    <span>Legal</span>
                                </template>
                                <b-row>
                                    <!-- timeline -->
                                    <b-col md="12" class="mb-2">
                                        <h4 class="mb-2">
                                            <feather-icon
                                                icon="ChevronsUpIcon"
                                                size="18"
                                                class="mr-50"
                                            />
                                            Legal Updates
                                        </h4>

                                        <app-timeline>
                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 4 - 40%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >01.03.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="40%"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>

                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 3 - 30%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >01.04.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="30"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>

                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 2 - 15%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >25.03.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="15"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>

                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 1 - 10%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >01.03.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <p>Some info here</p>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="10"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>
                                        </app-timeline>
                                    </b-col>
                                </b-row>
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon icon="ToolIcon" />
                                    <span>Payments</span>
                                </template>

                                <b-row>
                                    <!-- timeline -->
                                    <b-col md="12" class="mb-2">
                                        <h4 class="mb-2">
                                            <feather-icon
                                                icon="ChevronsUpIcon"
                                                size="18"
                                                class="mr-50"
                                            />
                                            Payment Updates
                                        </h4>

                                        <app-timeline>
                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 4 - 40%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >01.03.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        v-model="progressValue"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>

                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 3 - 30%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >01.04.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="30"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>

                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 2 - 15%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >25.03.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="15"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>

                                            <app-timeline-item
                                                variant="secondary"
                                            >
                                                <div
                                                    class="
                                                        d-flex
                                                        align-items-start
                                                        flex-sm-row
                                                        flex-column
                                                        flex-wrap
                                                        justify-content-between
                                                        mb-1 mb-sm-50
                                                    "
                                                >
                                                    <h6>Report Week 1 - 10%</h6>
                                                    <b-button
                                                        v-ripple.400="
                                                            'rgba(113, 102, 240, 0.15)'
                                                        "
                                                        variant="outline-primary"
                                                    >
                                                        <span
                                                            class="align-middle"
                                                            >01.03.2022</span
                                                        >
                                                        <feather-icon
                                                            icon="CalendarIcon"
                                                            class="mr-50"
                                                        />
                                                    </b-button>
                                                </div>
                                                <p>Some info here</p>
                                                <div class="progress-wrapper">
                                                    <b-progress
                                                        value="10"
                                                        max="100"
                                                        show-value
                                                        height="20px"
                                                    />
                                                </div>
                                            </app-timeline-item>
                                        </app-timeline>
                                    </b-col>
                                </b-row>
                            </b-tab>
                        </b-tabs>
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

                            <b-row>
                                <b-col lg="6" class="mb-2">
                                    <show-map lat=20.5937 lng=78.9629 />
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
                            </b-row>
                            <!-- Update -->
                            <!-- <b-col class="text-right">
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    type="submit"
                                    variant="primary"
                                    @click.prevent="updateListingTrigger"
                                >
                                    Update Details
                                    <b-spinner small v-if="isLoading" />
                                </b-button>
                            </b-col> -->
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
import { can } from "@/auth/authentication.js";
import ShowMap from '@/components/ShowMap.vue'

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

        ShowMap,
    },
    data() {
        return {
            progressValue: "40%",

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

            can
        };
    },
    methods: {
        ...mapActions({ loadLegalDocument: "contract/loadLegalDocument" }),



    },
    computed: {
        ...mapGetters({
            isLoading: "contract/getIsLoading",
        }),
    },
    mounted() {

        this.id = this.$route.params.listingId;

        this.loadLegalDocument({ listing_id: this.id })
            .then((response) => {
                if (response.success) {
                    this.listing = response.user[0].listing;
                    this.listingVisit = response.user;
                    console.log(response.user);
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
