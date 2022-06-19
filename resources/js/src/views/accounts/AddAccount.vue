<template>
    <div>
        <!-- Header -->
        <b-row class="mb-2">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Edit Account</h1>
                </b-card-text>
            </b-col>
        </b-row>

        <!-- form -->
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
                                        v-model="user.first_name"
                                        name="firstname"
                                        placeholder="First Name"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Username"
                                    label-for="user-name"
                                >
                                    <b-form-input
                                        v-model="user.user_name"
                                        name="username"
                                        placeholder="Username"
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group
                                    label="Last Name"
                                    label-for="account-name"
                                >
                                    <b-form-input
                                        v-model="user.last_name"
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
                                    <b-form-datepicker
                                            placeholder="Date of Birth"
                                            id="target_completion_dateto"
                                            v-model="user.date_of_birth"
                                            name="dateofbirth"
                                            class="mb-1 p-0"
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
                                    />
                                </b-form-group>
                            </b-col>
                            <b-col sm="4">
                                <b-form-group label="State" label-for="state">
                                    <b-form-input
                                        id="state"
                                        v-model="user.state"
                                        placeholder="State"
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
                                     @click="updateProfileTrigger"
                                >
                                    Add
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
    BAvatar,
    BFormDatepicker,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
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
        BSpinner,
        BAvatar,
        BFormDatepicker,
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
        };
    },
    computed: {
        ...mapGetters({ isLoading: "account/getIsLoading" }),

        userAvatar() { return this.user.avatar; },

        userAvatarText() {
          let f = this.user.first_name && this.user.first_name.substring(0, 1);
          let l = this.user.last_name && this.user.last_name.substring(0, 1);
          return f +""+ l
        }
    },
    methods: {
        ...mapActions({
            updateAccont: "account/updateAccont"
        }),

        updateProfileTrigger() {

            var accountData = new FormData();
            accountData.append('first_name', this.user.first_name);
            accountData.append('user_name', this.user.user_name);
            accountData.append('last_name', this.user.last_name);
            accountData.append('email', this.user.email);
            accountData.append('contact', this.user.contact);
            accountData.append('address', this.user.address);
            accountData.append('date_of_birth', this.user.date_of_birth);
            accountData.append('country', this.user.country);
            accountData.append('state', this.user.state);
            accountData.append('city', this.user.city);
            accountData.append('avatar', this.newAvatar);

            this.updateAccont(accountData)
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
};
</script>
