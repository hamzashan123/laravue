<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Add Visit Details on {{ listing.title }}</h1>

                    <b-badge :variant="statuses_color[1][listing.status]" v-if="listing.status">
                        {{ statuses_color[0][listing.status] }}
                    </b-badge>
                </b-card-text>
            </b-col>
        </b-row>

        <!-- Date and amount Form -->
        <b-form @submit.prevent enctype="multipart/form-data">
            <validation-observer ref="validationRules">
                <b-card>
                    <show-client-date-budget :listing="listing" />
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
                                    class="imag w-50 position-relative"
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
                                        fluid
                                        thumbnail
                                        class="w-100"
                                        :src="image"
                                    />

                                    <b-avatar
                                        variant="light-dark"
                                        square
                                        :text="image"
                                        size="md"
                                    />
                                    <!-- link button -->
                                    <b-button
                                        v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                        variant="outline-dark"
                                        size="sm"
                                        :href="image"
                                        target="_blank"
                                    >
                                        {{ image }}
                                    </b-button>

                                </div>
                            </div>
                            <div class="d-flex align-items-end">
                                <b-form-file
                                    v-model="imagesFileUploader"
                                    @change="onFileUpload"
                                    placeholder="Add Pictures"
                                    drop-placeholder="Drop file here..."
                                    multiple
                                    accept=".jpg, .png, .pdf"
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
                            </div>
                            <b-col class="text-right p-0">
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
                            <show-title-description heading="Listing Details" :listing="listing" />
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
import ShowMap from '@/components/ShowMap.vue'
import ShowTitleDescription from '@/components/ShowTitleDescription.vue'
import ShowAddress from '@/components/ShowAddress.vue'
import ShowClientDateBudget from '@/components/ShowClientDateBudget.vue'

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
        ShowMap,
        ShowTitleDescription,
        ShowAddress,
        ShowClientDateBudget,
    },
    data() {
        return {
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

        formatNames(files) {
            return this.newImages.length === 1 ? files[0].name : `${this.newImages.length} files selected`
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

                                this.$router.push({ name: "listings.visit", params: { id: this.id } });
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



    },
    computed: {
        ...mapGetters({
            isLoading: "listing/getIsLoading",
            isCreated: "listing/getIsCreated",
        }),
    },
    mounted() {

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
