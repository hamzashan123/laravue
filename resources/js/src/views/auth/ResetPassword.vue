<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">
      <!-- Brand logo-->
      <b-link class="brand-logo">
        <vuexy-logo />

        <h2 class="brand-text text-primary ml-1">Acme</h2>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col lg="8" class="d-none d-lg-flex align-items-center p-5">
        <div
          class="w-100 d-lg-flex align-items-center justify-content-center px-5"
        >
          <b-img :src="imgUrl" fluid alt="Register V2" />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Reset password-->
      <b-col lg="4" class="d-flex align-items-center auth-bg px-2 p-lg-5">
        <!-- code verify column -->
        <b-col sm="8" md="6" lg="12" class="px-xl-2 mx-auto" v-if="!isCodeVerified">
          <b-card-title title-tag="h2" class="font-weight-bold mb-1">
            <b-spinner
                class="mr-1"
                variant="primary"
                v-if="!errorInVerifying"
            />
            Verifying...

          </b-card-title>
          <b-card-text class="mb-2">
            Please wait while we're verifying your link...
          </b-card-text>
          <b-button
            v-if="errorInVerifying"
            type="submit"
            variant="primary"
            block
            :to="{ name: 'forgot' }"
            >
                Send link again!
              </b-button>
        </b-col>

        <!-- form column -->
        <b-col sm="8" md="6" lg="12" class="px-xl-2 mx-auto" v-if="isCodeVerified">
          <b-card-title title-tag="h2" class="font-weight-bold mb-1">
            Reset Password 🔒
          </b-card-title>
          <b-card-text class="mb-2">
            Your new password must be different from previously used passwords
          </b-card-text>

          <!-- form -->
          <validation-observer ref="simpleRules">
            <b-form
              class="auth-reset-password-form mt-2"
              method="POST"
              @submit.prevent="changePasswordTrigger"
            >
              <!-- password -->
              <b-form-group label="New Password" label-for="reset-password-new">
                <validation-provider
                  #default="{ errors }"
                  name="Password"
                  vid="Password"
                  rules="required|password"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid' : null"
                  >
                    <b-form-input
                      id="reset-password-new"
                      v-model="password"
                      :type="password1FieldType"
                      :state="errors.length > 0 ? false : null"
                      class="form-control-merge"
                      name="reset-password-new"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        :icon="password1ToggleIcon"
                        @click="togglePassword1Visibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- confirm password -->
              <b-form-group
                label-for="reset-password-confirm"
                label="Confirm Password"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Confirm Password"
                  rules="required|confirmed:Password"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid' : null"
                  >
                    <b-form-input
                      id="reset-password-confirm"
                      v-model="cPassword"
                      :type="password2FieldType"
                      class="form-control-merge"
                      :state="errors.length > 0 ? false : null"
                      name="reset-password-confirm"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        :icon="password2ToggleIcon"
                        @click="togglePassword2Visibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- submit button -->
              <b-button block type="submit" variant="primary">
                Set New Password
                <b-spinner small v-if="isLoading" />
              </b-button>
            </b-form>
          </validation-observer>

          <p class="text-center mt-2">
            <b-link :to="{ name:'login' }">
              <feather-icon icon="ChevronLeftIcon" /> Back to login
            </b-link>
          </p>
        </b-col>
      </b-col>
      <!-- /Reset password-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from "vee-validate";
import VuexyLogo from "@core/layouts/components/Logo.vue";
import {
  BRow,
  BCol,
  BCardTitle,
  BCardText,
  BForm,
  BFormGroup,
  BInputGroup,
  BInputGroupAppend,
  BLink,
  BFormInput,
  BButton,
  BImg,
  BSpinner,
} from "bootstrap-vue";
import { required } from "@validations";
import store from "@/store/index";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { mapActions, mapGetters } from "vuex";

export default {
  components: {
    VuexyLogo,
    BRow,
    BCol,
    BButton,
    BCardTitle,
    BCardText,
    BForm,
    BFormGroup,
    BImg,
    BInputGroup,
    BLink,
    BFormInput,
    BInputGroupAppend,
    ValidationProvider,
    ValidationObserver,
    BSpinner,
  },
  data() {
    return {
      userEmail: "",
      cPassword: "",
      password: "",
      isCodeVerified: false,
      errorInVerifying: false,
      sideImg: require("@/assets/images/pages/reset-password-v2.svg"),
      // validation
      required,

      // Toggle Password
      password1FieldType: "password",
      password2FieldType: "password",
    };
  },
  computed: {
    ...mapGetters({ isLoading: 'auth/isLoading'}),

    passwordToggleIcon() {
      return this.passwordFieldType === "password" ? "EyeIcon" : "EyeOffIcon";
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === "dark") {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require("@/assets/images/pages/reset-password-v2-dark.svg");
        return this.sideImg;
      }
      return this.sideImg;
    },
    password1ToggleIcon() {
      return this.password1FieldType === "password" ? "EyeIcon" : "EyeOffIcon";
    },
    password2ToggleIcon() {
      return this.password2FieldType === "password" ? "EyeIcon" : "EyeOffIcon";
    },
  },
  methods: {
    ...mapActions({ changePassword: "auth/changePassword", verifyCode: "auth/verifyCode" }),

    togglePassword1Visibility() {
      this.password1FieldType =
        this.password1FieldType === "password" ? "text" : "password";
    },
    togglePassword2Visibility() {
      this.password2FieldType =
        this.password2FieldType === "password" ? "text" : "password";
    },

    changePasswordTrigger() {
        let pEmail = this.$route.query.email

      this.$refs.simpleRules.validate().then( (success) => {
        if (success) {


          var authData = { email: pEmail, password: this.password, confirm_password: this.cPassword };

          this.changePassword(authData)
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
                    this.$router.push({ name: "login" });
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

    verifyCodeTrigger() {

        let pEmail = this.$route.query.email
        let pCode = this.$route.query.code

        var authData = { email: pEmail, code: pCode };

        this.verifyCode(authData)
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

                this.isCodeVerified = true

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
                this.errorInVerifying = true
            }
        })
        .catch((error) => {
            this.errorInVerifying = true
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
  },
  mounted() {
    this.verifyCodeTrigger()
  },

}
</script>

<style lang="scss">
@import "~@resources/scss/vue/pages/page-auth.scss";
</style>
