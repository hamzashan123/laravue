<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12" class="mb-2">
                <b-card-text> <h1>Update Listing</h1> </b-card-text>
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
                                            v-model="listing.target_completion_datefrom"
                                            name="target_completion_datefrom"
                                            :state="errors.length > 0 ? false : null "
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
                                        vid="min_budget"
                                        rules="required"
                                    >
                                        <b-form-input
                                            v-model="listing.min_budget"
                                            class="mb-1"
                                            placeholder="Minimum Budget"
                                            :state="
                                                errors.length > 0 ? false : null
                                            "
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
                                        vid="max_budget"
                                        rules="required|minVal:@min_budget"
                                    >
                                        <b-form-input
                                            v-model="listing.max_budget"
                                            placeholder="Maximum Budget"
                                            class="mb-1"
                                            :state="
                                                errors.length > 0 ? false : null
                                            "
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
                        <!-- Images -->
                        <b-col md="6" class="mb-2">
                            <div class="d-flex flex-wrap mb-2">
                                <div
                                    class="imag w-50 position-relative"
                                    v-for="(image, idx) in imagesShowWhileUpload"
                                    :key="idx"
                                >
                                    <b-button
                                        @click="removeSelectedImage(idx, image)"
                                        variant="gradient-danger"
                                        class="btn-icon rounded-circle position-absolute z-index"
                                        >
                                        <feather-icon icon="XIcon" />
                                    </b-button>
                                    <b-img
                                        fluid
                                        thumbnail
                                        class="w-100 listing-image-fixed-height"
                                        :src="image"
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
                                    :file-name-formatter="formatNames"
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
                        </b-col>
                        <!-- Details Form -->
                        <b-col md="6" class="mb-2">
                            <h4 class="mb-2">
                                <feather-icon
                                    icon="ChevronsUpIcon"
                                    size="18"
                                    class="mr-50"
                                />
                                Listing Details ( Please enter as mush as
                                possible )
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
                                />
                            </div>
                            <b-row>
                                <b-col lg="6" class="mb-2">
                                    <b-form-input
                                        v-model="gmapAutocompelte"
                                        id="gmap-autocompelte"
                                        placeholder="Search Address"
                                        @focus="setGmapOnFocus"
                                    />
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
                                        />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <!-- Update -->
                            <b-col class="text-right">
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
                                    type="submit"
                                    variant="primary"
                                    @click.prevent="updateListingTrigger"
                                >
                                    Update Details
                                    <b-spinner small v-if="isLoading" />
                                </b-button>
                            </b-col>
                        </b-col>
                    </b-row>
                </b-card>
            </validation-observer>
        </b-form>
    </div>
</template>

<script>
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
extend('minVal', {
  params: ['target'],
  validate(value, { target }) {
    return parseInt(value)  > parseInt(target);
  },
  message: 'The {_field_} should be greater then {target}'
});

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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import { required } from "@validations";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

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
    },
    data() {
        return {
            // map
            gmapAutocompelte: "",
            autocomplete: null,
            place: '',
            latLng: { lat: 20.5937, lng: 78.9629 },
            // listing
            imagesShowWhileUpload: [],
            imagesFileUploader: [],
            newImages: [],
            isFileUploaderFull: false,
            id: '',
            listing: {
                name: "",
                target_completion_datefrom: "",
                target_completion_dateto: "",
                minimum_budget: null,
                maximum_budget: null,
                detail: "",
                address_line1: "",
                address_line2: "",
                country: "",
                state: null,
                district: null,
            },
            //   Validation
            required,
        };
    },
    methods: {
        onFileUpload(e) {
            let getImages = e.target.files;

            let maxImg = this.imagesShowWhileUpload.length;

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
                this.imagesFileUploader = null;
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

        formatNames(files) {
            return this.newImages.length === 1 ? files[0].name : `${this.newImages.length} files selected`
        },

        clearFiles() {
            this.imagesFileUploader = null;
            this.imagesShowWhileUpload = [];
            this.newImages = [];
            this.isFileUploaderFull = false;
        },

        removeSelectedImage(index, imageUrl) {
            this.imagesShowWhileUpload.splice(index, 1);
            this.newImages.splice(index, 1);
            this.imagesFileUploader.splice(index, 1);
            // checking if it is image url
            if( /(jpg|gif|png|JPG|GIF|PNG|JPEG|jpeg)$/.test(imageUrl) ) {
                this.archiveListingImagesTrigger(imageUrl)
            }
        },

        ...mapActions({
            updateListing: "listing/updateListing",
            loadListing: "listing/loadListing",
            archiveListingImages: "listing/archiveListingImages"
        }),

        async updateListingTrigger() {
            this.$refs.validationRules.validate().then(async (success) => {
                if (success) {
                    let listingData = new FormData();
                    listingData.append("id", this.id);
                    listingData.append("title", this.listing.title);
                    listingData.append(
                        "target_completion_datefrom",
                        this.listing.target_completion_datefrom
                    );
                    listingData.append(
                        "target_completion_dateto",
                        this.listing.target_completion_dateto
                    );
                    listingData.append("min_budget", this.listing.min_budget);
                    listingData.append("max_budget", this.listing.max_budget);
                    listingData.append("description", this.listing.description);
                    listingData.append(
                        "address_line1",
                        this.listing.address_line1
                    );
                    listingData.append(
                        "address_line2",
                        this.listing.address_line2
                    );
                    listingData.append("country", this.listing.country);
                    listingData.append("state", this.listing.state);
                    listingData.append("district", this.listing.district);
                    listingData.append("lat", this.latLng.lat);
                    listingData.append("lon", this.latLng.lng);

                    this.newImages.forEach((newImage) => {
                        listingData.append("images[]", newImage);
                    });

                    await this.updateListing(listingData)
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

                                this.$router.push({ name: 'listings.view', params: { id: this.id} })
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

        archiveListingImagesTrigger(imageUrl) {
            let imageData = new FormData();
            imageData.append("listing_id", this.id);
            imageData.append("image_url", imageUrl);

            this.archiveListingImages(imageData)
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
            this.autocomplete.addListener("place_changed", this.getAddressOnChange);
        },
        // Get address on change
        getAddressOnChange() {
            this.place = this.autocomplete.getPlace();

            this.latLng = { lat: this.place.geometry.location.lat(), lng: this.place.geometry.location.lng() }

            this.initMap()


             for (const component of this.place.address_components) {
                // @ts-ignore remove once typings fixed
                const componentType = component.types[0];

                switch (componentType) {
                case "street_number": {
                    this.listing.address_line1 = `${component.long_name} ${address1}`;
                    break;
                }

                case "route": {
                    this.listing.address_line1 = component.short_name;
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
        }

    },
    computed: {
        ...mapGetters({
            isLoading: "listing/getIsLoading",
            isCreated: "listing/getIsCreated",

        }),
    },
    mounted() {
        this.initMap()

        this.id = this.$route.params.listingId;

        const getUser = JSON.parse(localStorage.getItem("userData")) || ''
        const user_Role = getUser.user_role || '';
        const userRoleID = user_Role.id || ''

        this.loadListing({ id: this.id, role_id: userRoleID })
            .then((response) => {
                if (response.success) {
                    this.listing = response.data[0];
                    this.imagesShowWhileUpload = response.data[0].images
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
