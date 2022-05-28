<template>
    <div>
        <!-- Header -->
        <b-row class="mb-2">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Profile Setting</h1>
                </b-card-text>
            </b-col>
        </b-row>
        <!-- </b-card> -->
        <setting-tab-button> </setting-tab-button>

        <!-- form -->
        <b-form class="mt-2" enctype="multipart/form-data" @submit.prevent>
            <b-row>
                <b-col md="4">
                    <b-card>
                        <!-- media -->
                        <b-media no-body>
                            <b-media-aside>
                                <b-link>
                                    <b-img
                                        rounded
                                        :src="userAvatar"
                                        height="80"
                                        accept="image/*"
                                    />
                                </b-link>
                                <!--/ avatar -->
                            </b-media-aside>

                            <b-media-body class="mt-75 ml-75">
                                <h3>
                                    {{ user.firstname }} {{ user.lastname }}
                                </h3>
                                <!-- upload button -->
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    size="sm"
                                    class="mb-75 mr-75"
                                    @click="$refs.refInputEl.$el.click()"
                                >
                                    Upload
                                </b-button>
                                <b-form-file
                                    ref="refInputEl"
                                    v-model="imageFileUploader"
                                    @change="onFileUpload"
                                    accept=".jpg, .png, .gif"
                                    :hidden="true"
                                    plain
                                />
                                <!--/ upload button -->

                                <b-card-text
                                    >Allowed JPG, GIF or PNG.</b-card-text
                                >
                            </b-media-body>
                        </b-media>
                        <!--/ media -->
                    </b-card>
                </b-col>
                <b-col md="8">
                    <b-card>
                        <b-row>
                            <b-col sm="4">
                                <b-form-group
                                    label="First Name"
                                    label-for="account-name"
                                >
                                    <b-form-input
                                        v-model="user.firstname"
                                        name="firstname"
                                        placeholder="First Name"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Middle Name"
                                    label-for="middle-name"
                                >
                                    <b-form-input
                                        v-model="user.middlename"
                                        name="middlename"
                                        placeholder="Middle Name"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Last Name"
                                    label-for="account-name"
                                >
                                    <b-form-input
                                        v-model="user.lastname"
                                        name="lastname"
                                        placeholder="Last Name"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="E-mail"
                                    label-for="account-e-mail"
                                >
                                    <b-form-input
                                        v-model="user.email"
                                        name="email"
                                        placeholder="Email"
                                        required
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="Contact"
                                    label-for="contact"
                                >
                                    <b-form-input
                                        v-model="user.contact"
                                        name="contact"
                                        placeholder="Contact"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="Date of Birth"
                                    label-for="dateofbirth"
                                >
                                    <b-form-input
                                        v-model="user.dateofbirth"
                                        name="dateofbirth"
                                        placeholder="Date of Birth"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="Address"
                                    label-for="address"
                                >
                                    <b-form-input
                                        v-model="user.address"
                                        name="address"
                                        placeholder="Address"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Country"
                                    label-for="country"
                                >
                                    <b-form-input
                                        id="country"
                                        v-model="user.country"
                                        placeholder="Country"
                                        required
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="State" label-for="state">
                                    <b-form-input
                                        id="state"
                                        v-model="user.state"
                                        placeholder="State"
                                        required
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="City" label-for="city">
                                    <b-form-input
                                        id="city"
                                        v-model="user.city"
                                        placeholder="City"
                                        required
                                    />
                                </b-form-group>
                            </b-col>

                            <!-- alert -->
                            <!-- <b-col cols="12" class="mt-75">
                                <b-alert show variant="warning" class="mb-50">
                                    <h4 class="alert-heading">
                                        Your email is not confirmed. Please
                                        check your inbox.
                                    </h4>
                                    <div class="alert-body">
                                        <b-link class="alert-link">
                                            Resend confirmation
                                        </b-link>
                                    </div>
                                </b-alert>
                            </b-col> -->
                            <!--/ alert -->

                            <b-col cols="12">
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    class="mt-2 mr-1"
                                     type="submit"
                                     @click="UpdateProfileTrigger"
                                >
                                    Save changes
                                    <b-spinner small v-if="isLoading" />
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>
import {
    BFormFile,
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BAlert,
    BCard,
    BCardText,
    BMedia,
    BMediaAside,
    BMediaBody,
    BLink,
    BImg,
    BFormSelect,
    BSpinner,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import SettingTabButton from "./SettingTabButton.vue";
import { mapActions, mapGetters } from "vuex";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
    components: {
        BButton,
        BForm,
        BImg,
        BFormFile,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BAlert,
        BCard,
        BCardText,
        BMedia,
        BMediaAside,
        BMediaBody,
        BLink,
        BFormSelect,
        SettingTabButton,
        BSpinner,
    },
    directives: {
        Ripple,
    },
    data() {
        return {
            user: {
                avatar: '',
            },
            newAvatar: null,
            imageFileUploader: null,
            imageShowWhileUpload: null,
        };
    },
    computed: {
        ...mapGetters({
            isLoading: "setting/getIsLoading",
        }),

        userAvatar() { return this.user.avatar; },
    },
    mounted() {
        const getUser = JSON.parse(localStorage.getItem("userData"));
        this.user = getUser;
    },
    methods: {
        // resetForm() {
        //   this.user = JSON.parse(JSON.stringify(this.generalData));
        // },
        ...mapActions({
            updateProfile: "setting/updateProfile",
        }),

        UpdateProfileTrigger() {

            var ProfileData = new FormData();
            ProfileData.append('firstname', this.user.firstname);
            ProfileData.append('middlename', this.user.middlename);
            ProfileData.append('lastname', this.user.lastname);
            ProfileData.append('email', this.user.email);
            ProfileData.append('contact', this.user.contact);
            ProfileData.append('address', this.user.address);
            ProfileData.append('dateofbirth', this.user.dateofbirth);
            ProfileData.append('country', this.user.country);
            ProfileData.append('state', this.user.state);
            ProfileData.append('city', this.user.city);
            ProfileData.append('avatar', this.newAvatar);

            console.log(ProfileData, "profileData");
            this.updateProfile(ProfileData)
                .then((response) => {
                    console.log(response, "r");
                    if( response.success ) {

                        this.$toast({
                            component: ToastificationContent,
                            props: { title: response.message, icon: "EditIcon", variant: "success" },
                        });
                    } else {
                        this.$toast({
                            component: ToastificationContent,
                            props: { title: response.message, icon: "EditIcon", variant: "danger" },
                        });
                    }
                })
                .catch((err) => {
                    console.log(err, "e");
                    this.$toast({
                        component: ToastificationContent,
                        props: {
                            title: err,
                            icon: "EditIcon",
                            variant: "danger",
                        },
                    });
                });
        },
        onFileUpload(e) {
            let reader = new FileReader();
            reader.readAsDataURL( e.target.files[0] );
            reader.onload = (e) => {
                this.imageShowWhileUpload = e.target.result;
            };

            this.user.avatar = URL.createObjectURL(e.target.files[0]);
            this.newAvatar = e.target.files[0];

            console.log(this.newAvatar);
        },
        clearFiles() {
            this.imageShowWhileUpload = null;
        },
        imageUrlAlt() {
            this.user.avatar = require("@/assets/images/portrait/small/default.jpg");
        },
    },
    setup() {},
};
</script>
