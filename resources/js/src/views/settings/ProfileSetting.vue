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
        <validation-observer ref="validationRules">
        <b-form class="mt-2" enctype="multipart/form-data" @submit.prevent>
            <b-row>
                <b-col md="4">
                    <b-card>
                        <!-- media -->
                        <b-media no-body>
                            <b-media-aside>
                                <b-link>
                                    <b-avatar
                                    size="80"
                                    variant="light-primary"
                                    badge
                                    :text="userAvatarText"
                                    :src="userAvatar"
                                    class="badge-minimal"
                                    badge-variant="success"
                                    accept="image/*"
                                />
                                </b-link>
                                <!--/ avatar -->
                            </b-media-aside>

                            <b-media-body class="mt-75 ml-75">
                                <div class="mb-2">
                                    <h3>{{ user.first_name }} {{ user.last_name }} </h3>
                                    <span class="user-status">{{ userRole.role }}</span>
                                </div>
                                <!-- upload button -->
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    size="sm"
                                    class="mb-1 mr-2"
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
                                    <validation-provider
                                        #default="{ errors }"
                                        name="First Name"
                                        rules="required"
                                        >
                                    <b-form-input
                                        v-model="user.first_name"
                                        name="firstname"
                                        placeholder="First Name"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Username"
                                    label-for="user-name"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="User Name"
                                    rules="required"
                                    >
                                    <b-form-input

                                        v-model="user.user_name"
                                        name="username"
                                        placeholder="Username"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Last Name"
                                    label-for="account-name"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Last Name"
                                    rules="required"
                                    >
                                    <b-form-input
                                        v-model="user.last_name"
                                        name="lastname"
                                        placeholder="Last Name"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="E-mail"
                                    label-for="account-e-mail"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Email"
                                    rules="required|email"
                                    >
                                    <b-form-input
                                        disabled
                                        v-model="user.email"
                                        name="email"
                                        placeholder="Email"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="Contact"
                                    label-for="contact"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Contact"
                                    rules="required"
                                    >
                                    <b-form-input
                                        v-model="user.contact"
                                        name="contact"
                                        placeholder="Contact"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="Date of Birth"
                                    label-for="dateofbirth"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Date of Birth"
                                    rules="required"
                                    >
                                    <b-form-datepicker
                                        placeholder="Date of Birth"
                                        id="target_completion_dateto"
                                        v-model="user.date_of_birth"
                                        name="dateofbirth"
                                        class="mb-1 p-0"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="6">
                                <b-form-group
                                    label="Address"
                                    label-for="address"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Address"
                                    rules="required"
                                    >
                                    <b-form-input
                                        v-model="user.address"
                                        name="address"
                                        placeholder="Address"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Country"
                                    label-for="country"
                                >
                                <validation-provider
                                    #default="{ errors }"
                                    name="Country"
                                    rules="required"
                                    >
                                    <b-form-input
                                        id="country"
                                        v-model="user.country"
                                        placeholder="Country"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="State" label-for="state">
                                    <validation-provider
                                    #default="{ errors }"
                                    name="State"
                                    rules="required"
                                    >
                                    <b-form-input
                                        id="state"
                                        v-model="user.state"
                                        placeholder="State"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="City" label-for="city">
                                    <validation-provider
                                    #default="{ errors }"
                                    name="State"
                                    rules="required"
                                    >
                                    <b-form-input
                                        id="city"
                                        v-model="user.city"
                                        placeholder="City"
                                        :state="errors.length > 0 ? false:null"
                                    />
                                    <small class="text-danger">{{ errors[0] }}</small>
                                    </validation-provider>
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
        </validation-observer>
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
    BAvatar,
    BFormDatepicker,
} from "bootstrap-vue";
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { required, email } from '@validations'
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
        BAvatar,
        BFormDatepicker,
        // validations
        ValidationProvider,
        ValidationObserver,
    },
    directives: {
        Ripple,
    },
    data() {
        return {
            user: {
                avatar: '',
            },
            userRole: {},
            newAvatar: null,
            imageFileUploader: null,
            imageShowWhileUpload: null,

            // validation
            required,
            email,
        };
    },
    computed: {
        ...mapGetters({ isLoading: "setting/getIsLoading" }),

        userAvatar() { return this.user.avatar; },

        userAvatarText() {
          let f = this.user.first_name && this.user.first_name.substring(0, 1);
          let l = this.user.last_name && this.user.last_name.substring(0, 1);
          return f +""+ l
        }
    },
    mounted() {
        const getUser = JSON.parse(localStorage.getItem("userData"));
        this.user = getUser;

        const userRole = getUser.user_role;
        this.userRole = userRole
    },
    methods: {
        // resetForm() {
        //   this.user = JSON.parse(JSON.stringify(this.generalData));
        // },
        ...mapActions({
            updateProfile: "setting/updateProfile",
        }),

        UpdateProfileTrigger() {
            this.$refs.validationRules.validate().then(success => {
                if (success) {

                var ProfileData = new FormData();
                ProfileData.append('first_name', this.user.first_name);
                ProfileData.append('user_name', this.user.user_name);
                ProfileData.append('last_name', this.user.last_name);
                ProfileData.append('email', this.user.email);
                ProfileData.append('contact', this.user.contact);
                ProfileData.append('address', this.user.address) ;
                ProfileData.append('date_of_birth', this.user.date_of_birth);
                ProfileData.append('country', this.user.country);
                ProfileData.append('state', this.user.state);
                ProfileData.append('city', this.user.city);
                ProfileData.append('avatar', this.newAvatar);

                this.updateProfile(ProfileData)
                    .then((response) => {
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
                                title: "Error while updating!",
                                icon: "EditIcon",
                                variant: "danger",
                            },
                        });
                    });
                 }
            })
        },
        onFileUpload(e) {
            let reader = new FileReader();
            reader.readAsDataURL( e.target.files[0] );
            reader.onload = (e) => {
                this.imageShowWhileUpload = e.target.result;
            };

            this.user.avatar = URL.createObjectURL(e.target.files[0]);
            this.newAvatar = e.target.files[0];
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
