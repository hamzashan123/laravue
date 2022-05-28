<template>
    <b-card>
        <!-- form -->
        <b-form @submit.prevent>
            <b-row>
                <!-- new password -->
                <b-col md="6">
                    <b-form-group label-for="password" label="New Password">
                        <b-input-group class="input-group-merge">
                            <b-form-input
                                id="password"
                                v-model="password"
                                :type="passwordFieldTypeNew"
                                name="password"
                                placeholder="New Password"
                                required
                            />
                            <b-input-group-append is-text>
                                <feather-icon
                                    :icon="passwordToggleIconNew"
                                    class="cursor-pointer"
                                    @click="togglePasswordNew"
                                />
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <!--/ new password -->

                <!-- retype password -->
                <b-col md="6">
                    <b-form-group
                        label-for="confirm_password"
                        label="Retype New Password"
                    >
                        <b-input-group class="input-group-merge">
                            <b-form-input
                                id="confirm_password"
                                v-model="confirm_password"
                                :type="passwordFieldTypeRetype"
                                name="confirm_password"
                                placeholder="New Password"
                                required
                            />
                            <b-input-group-append is-text>
                                <feather-icon
                                    :icon="passwordToggleIconRetype"
                                    class="cursor-pointer"
                                    @click="togglePasswordRetype"
                                />
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <!--/ retype password -->

                <!-- buttons -->
                <b-col cols="12">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        class="mt-1 mr-1"
                        type="submit"
                        @click="updatePassTrigger"
                    >
                        Save changes
                        <b-spinner small v-if="isLoading" />
                    </b-button>
                </b-col>
                <!--/ buttons -->
            </b-row>
        </b-form>
    </b-card>
</template>

<script>
import {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BCard,
    BInputGroup,
    BInputGroupAppend,
    BCardText,
    BSpinner,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { mapActions, mapGetters } from "vuex";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { required } from "@validations";

export default {
    components: {
        BButton,
        BForm,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BCard,
        BInputGroup,
        BInputGroupAppend,
        BCardText,
        BSpinner,
    },
    directives: {
        Ripple,
    },
    data() {
        return {
            user: null,
            password: "",
            confirm_password: "",
            passwordFieldTypeNew: "password",
            passwordFieldTypeRetype: "password",
        };
    },
    computed: {
        passwordToggleIconNew() {
            return this.passwordFieldTypeNew === "password"
                ? "EyeIcon"
                : "EyeOffIcon";
        },
        passwordToggleIconRetype() {
            return this.passwordFieldTypeRetype === "password"
                ? "EyeIcon"
                : "EyeOffIcon";
        },

        ...mapGetters({ isLoading: 'setting/getIsLoading' })
    },
    methods: {
        togglePasswordNew() {
            this.passwordFieldTypeNew =
                this.passwordFieldTypeNew === "password" ? "text" : "password";
        },
        togglePasswordRetype() {
            this.passwordFieldTypeRetype =
                this.passwordFieldTypeRetype === "password"
                    ? "text"
                    : "password";
        },

        ...mapActions({ updatePassword: "setting/updatePassword" }),

        updatePassTrigger() {
            var passData = new FormData();
            passData.append('email', this.user.email);
            passData.append('password', this.password);
            passData.append('confirm_password', this.confirm_password);

            console.log(passData, "passData");
            this.updatePassword(passData)
                .then((response) => {
                    console.log(response, "r");
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
    },
    mounted() {
        const getUser = JSON.parse(localStorage.getItem("userData"));
        this.user = getUser;
    },
};
</script>
