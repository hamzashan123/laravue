<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Add Visit Details on {{ listing.title }}</h1>

                    <b-badge :variant="statuses_color[1][listing.status]">
                        {{ statuses_color[0][listing.status] }}
                    </b-badge>
                </b-card-text>
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
                            <h4 class="mb-2 text-primary">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Add Visit Detail
                            </h4>
                            <div class="mt-2">
                                <b-row>
                                    <b-col md="12">
                                        <b-form-group
                                            label="Visit Summary"
                                            label-for="visit_summary"
                                        >
                                            <b-form-input
                                                id="visit_summary"
                                                v-model="
                                                    listingVisit.visit_summary
                                                "
                                                placeholder="Add Visit Summary"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="12">
                                        <b-form-group
                                            label="Visit Detail"
                                            label-for="visit_detail"
                                        >
                                            <b-form-textarea
                                                id="visit_detail"
                                                v-model="
                                                    listingVisit.visit_detail
                                                "
                                                placeholder="Add Visit Detail"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Percetange"
                                            label-for="Percetange"
                                        >
                                            <b-form-input
                                                v-model="
                                                    listingVisit.percentage
                                                "
                                                id="Percetange"
                                                placeholder="Add project status"
                                            />
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Visit Date"
                                            label-for="visit_date"
                                        >
                                            <b-form-datepicker
                                                v-model="
                                                    listingVisit.visit_date
                                                "
                                                placeholder="Select Visit Date"
                                                id="visit_date"
                                                class="mb-1 p-0"
                                                name="visit_date"
                                            />
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </div>

                            <hr>

                            <h4 class="mb-2 text-primary">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Add Media
                            </h4>
                            <div class="mt-2 mb-3">

                                <div class="d-flex flex-wrap mb-2">
                                <div
                                    class="imag w-25 position-relative"
                                    v-for="(image, idx) in imagesShowWhileUpload"
                                    :key="idx"
                                >
                                    <b-button
                                        @click="removeSelectedImage(idx)"
                                        variant="gradient-danger"
                                        class="btn-icon rounded-circle position-absolute z-index"
                                        >
                                        <feather-icon icon="XIcon" />
                                    </b-button>
                                    <b-img
                                        thumbnail
                                        class="w-100"
                                        :src="image.image"
                                    />

                                </div>
                            </div>
                            <div class="d-flex align-items-end">
                                <b-form-file
                                    v-model="imagesFileUploader"
                                    @change="onFileUpload"
                                    placeholder="Add Pictures"
                                    drop-placeholder="Drop file here..."
                                    multiple
                                    accept=".jpg, .png,"
                                    :disabled="isFileUploaderFull"
                                />
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    class="ml-2"
                                    type="submit"
                                    variant="dark"
                                    @click="clearFiles"
                                >
                                    Clear
                                </b-button>
                            </div>
                            </div>
                            <b-col class="text-right">
                                <b-button
                                    v-ripple.400="
                                        'rgba(255, 255, 255, 0.15)'
                                    "
                                    type="submit"
                                    variant="primary"
                                    @click="uploadVisitTrigger"
                                >
                                    Save Visit
                                    <b-spinner small v-if="isLoading" />
                                </b-button>
                            </b-col>
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
                            <b-row>
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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { required } from "@validations";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { statuses_color } from "@/fieldsdata/index.js";

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
    },
    data() {
        return {
            // map
            gmapAutocompelte: "",
            autocomplete: null,
            place: "",
            latLng: { lat: 20.5937, lng: 78.9629 },
            // listing
            imagesShowWhileUpload: [],
            imagesFileUploader: [],
            newImages: [],
            isFileUploaderFull: false,
            id: "",
            listing: {},
            listingVisit: {},
            //   Validation
            required,

            statuses_color
        };
    },
    methods: {
        onFileUpload(e) {
            let getImages = e.target.files;

            let maxImg = this.imagesShowWhileUpload.length;
            console.log(maxImg);

            if (maxImg < 5) {
                getImages.forEach((getImage) => {
                    let reader = new FileReader();
                    reader.readAsDataURL(getImage);
                    reader.onload = (e) => {
                        this.imagesShowWhileUpload.push(e.target.result);
                    };
                    this.newImages.push(getImage);
                });
            } else {
                this.isFileUploaderFull = true;
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: "Maximum 5 Images alllowed!",
                        icon: "EditIcon",
                        variant: "warning",
                    },
                });
            }
        },
        clearFiles() {
            this.imagesFileUploader = null;
            this.imagesShowWhileUpload = [];
            this.newImages = [];
            this.isFileUploaderFull = false;
        },

        removeSelectedImage(index) {
            this.imagesShowWhileUpload.splice(index, 1);
            this.newImages.splice(index, 1);
            this.imagesFileUploader.splice(index, 1);
        },

        ...mapActions({
            uploadVisit: "listing/uploadVisit",
            loadListing: "listing/loadListing",
        }),

        uploadVisitTrigger() {
            this.$refs.validationRules.validate().then((success) => {
                if (success) {
                    let visitData = new FormData();
                    visitData.append("listing_id", this.id)
                    visitData.append("visit_date", this.listingVisit.visit_date)
                    visitData.append("percentage", this.listingVisit.percentage)
                    visitData.append("visit_summary", this.listingVisit.visit_summary)
                    visitData.append("visit_detail", this.listingVisit.visit_detail)

                    this.newImages.forEach((newImage) => {
                        visitData.append("images[]", newImage);
                    });

                    this.uploadVisit(visitData)
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

                                this.$router.push({
                                    name: "listings.view",
                                    params: { id: this.id },
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
                                    title: "Error While Adding!",
                                    icon: "EditIcon",
                                    variant: "danger",
                                },
                            });
                        });
                }
            });
        },

        // Initialize Google Map on focus
        setGmapOnFocus() {
            this.autocomplete = new google.maps.places.Autocomplete(
                document.getElementById("gmap-autocompelte"),
                {
                    componentRestrictions: { country: ["in"] },
                    fields: ["address_components", "geometry"],
                    types: ["address"],
                }
            );
            // console.log("autocomplete", this.autocomplete);
            this.autocomplete.addListener(
                "place_changed",
                this.getAddressOnChange
            );
        },
        // Get address on change
        getAddressOnChange() {
            this.place = this.autocomplete.getPlace();

            // let lat = place.geometry.location.lat()
            // let lng = place.geometry.location.lng()

            this.latLng = {
                lat: this.place.geometry.location.lat(),
                lng: this.place.geometry.location.lng(),
            };

            this.initMap();

            for (const component of this.place.address_components) {
                // @ts-ignore remove once typings fixed
                const componentType = component.types[0];

                switch (componentType) {
                    case "street_number": {
                        this.listing.address_line1 = `${component.long_name} ${address1}`;
                        break;
                    }

                    case "route": {
                        this.listing.address_line1 += component.short_name;
                        break;
                    }
                    case "locality":
                        this.listing.district = component.long_name;
                        break;
                    case "administrative_area_level_1": {
                        this.listing.state = component.long_name;
                        break;
                    }
                    case "country":
                        this.listing.country = component.long_name;
                        break;
                }
            }
        },
        // Initialize map
        initMap() {
            let map = new google.maps.Map(document.getElementById("map"), {
                center: this.latLng,
                zoom: 12,
            });
        },
    },
    computed: {
        ...mapGetters({
            isLoading: "listing/getIsLoading",
            isCreated: "listing/getIsCreated",
        }),
    },
    mounted() {
        this.initMap();

        this.id = this.$route.params.listingId;

        const getUser = JSON.parse(localStorage.getItem("userData")) || "";
        const user_Role = getUser.user_role || "";
        const userRoleID = user_Role.id || "";

        this.loadListing({ id: this.id, role_id: userRoleID })
            .then((response) => {
                if (response.success) {
                    this.listing = response.data[0];
                    console.log(response.data[0].images);
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
