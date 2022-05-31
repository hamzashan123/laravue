<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Brand logo-->
      <b-link class="brand-logo">
        <vuexy-logo />

        <h2 class="brand-text text-primary ml-1">
          Acme
        </h2>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col
        lg="8"
        class="d-none d-lg-flex align-items-center p-5"
      >
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img
            fluid
            :src="imgUrl"
            alt="Register V2"
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Register-->
      <b-col
        lg="4"
        class="d-flex align-items-center auth-bg px-2 p-lg-5"
      >
        <b-col
          sm="8"
          md="6"
          lg="12"
          class="px-xl-2 mx-auto"
        >
          <b-card-title
            title-tag="h2"
            class="font-weight-bold mb-1"
          >
            Adventure starts here 🚀
          </b-card-title>
          <b-card-text class="mb-2">
            Make your app management easy and fun!
          </b-card-text>

          <!-- form -->
          <validation-observer ref="registerForm">
            <b-form class="auth-register-form mt-2">
              <!-- first_name -->
              <b-form-group
                label="First Name"
                label-for="register-first_name"
              >
                <validation-provider
                  #default="{ errors }"
                  name="First Name"
                  rules="required"
                >
                  <b-form-input
                    id="register-first_name"
                    v-model="first_name"
                    name="register-first_name"
                    :state="errors.length > 0 ? false:null"
                    placeholder="johndoe"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- last_name -->
              <b-form-group
                label="Last Name"
                label-for="register-last_name"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Last Name"
                  rules="required"
                >
                  <b-form-input
                    id="register-last_name"
                    v-model="last_name"
                    name="register-last_name"
                    :state="errors.length > 0 ? false:null"
                    placeholder="johndoe"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- email -->
              <b-form-group
                label="Email"
                label-for="register-email"
              >
                <validation-provider
                  #default="{ errors }"
                  name="email"
                  rules="required|email"
                >
                  <b-form-input
                    id="register-email"
                    v-model="email"
                    name="register-email"
                    :state="errors.length > 0 ? false:null"
                    placeholder="john@example.com"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- password -->
              <b-form-group
                label-for="password"
                label="Password"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Password"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid':null"
                  >
                    <b-form-input
                      id="password"
                      v-model="password"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      :state="errors.length > 0 ? false:null"
                      name="password"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        :icon="passwordToggleIcon"
                        class="cursor-pointer"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- confirm_password -->
              <b-form-group
                label-for="confirm_password"
                label="Confirm Password"
              >
                <validation-provider
                  #default="{ errors }"
                  name="confirm_password"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid':null"
                  >
                    <b-form-input
                      id="confirm_password"
                      v-model="confirm_password"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      :state="errors.length > 0 ? false:null"
                      name="confirm_password"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        :icon="passwordToggleIcon"
                        class="cursor-pointer"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- Select Role -->
              <b-form-group
                label="Sign up as a"
                label-for="role"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Role"
                  rules="required"
                >
                  <b-form-radio-group
                    v-model="role_id"
                    :options="role_options"
                    class=""
                    name="role_id"
                    >
                    </b-form-radio-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- divider -->
                <div class="divider my-2"></div>

              <b-form-group>
                <b-form-checkbox
                  id="register-privacy-policy"
                  v-model="status"
                  name="checkbox-1"
                >
                  I agree to
                  <b-link>privacy policy & terms</b-link>
                </b-form-checkbox>
              </b-form-group>

              <b-button
                variant="primary"
                block
                type="submit"
                @click.prevent="registerTrigger"
              >
                Sign up
                <b-spinner small v-if="isLoading"></b-spinner>
              </b-button>
            </b-form>
          </validation-observer>

          <p class="text-center mt-2">
            <span>Already have an account?</span>
            <b-link :to="{name:'login'}">
              <span>&nbsp;Sign in instead</span>
            </b-link>
          </p>

        </b-col>
      </b-col>
    <!-- /Register-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BRow,
  BCol,
  BLink,
  BButton,
  BForm,
  BFormCheckbox,
  BFormGroup,
  BFormInput,
  BInputGroup,
  BInputGroupAppend,
  BImg,
  BCardTitle,
  BCardText,
  BFormRadioGroup,
  BSpinner,
} from 'bootstrap-vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { mapActions, mapGetters } from 'vuex'

export default {
  components: {
    VuexyLogo,
    BRow,
    BImg,
    BCol,
    BLink,
    BButton,
    BForm,
    BCardText,
    BCardTitle,
    BFormCheckbox,
    BFormGroup,
    BFormInput,
    BInputGroup,
    BInputGroupAppend,
    BFormRadioGroup,
    BSpinner,
    // validations
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      first_name: '',
      last_name: '',
      email: '',
      password: '',
      confirm_password: '',
      country: 'India',
      contact: '0',
      role_id: '',
      role_options: [
        { text: 'Client', value: '1' },
        { text: 'Contractor', value: '2' },
      ],
      sideImg: require('@/assets/images/pages/register-v2.svg'),
      // validation
      required,
      email,
    }
  },
  computed: {
      ...mapGetters({ isLoading: 'auth/isLoading' }),

    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/register-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {

    ...mapActions({ register: "auth/register" }),

    registerTrigger() {
      this.$refs.registerForm.validate().then(success => {
        if (success) {

            let registerData = new FormData();
            registerData.append( "first_name", this.first_name );
            registerData.append( "last_name", this.last_name );
            registerData.append( "email", this.email );
            registerData.append( "password", this.password );
            registerData.append( "confirm_password", this.confirm_password );
            registerData.append( "contact", this.contact );
            registerData.append( "country", this.country );
            registerData.append( "role_id", this.role_id );

            this.register(registerData)
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

                        // this.first_name = this.last_name = this.emai = this.password = this.confirm_password = this.contact = this.country = this.role_id = ''

                        this.$router.push({ name: 'login' })


                    } else {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "danger",
                            },
                        });
                        this.$refs.registerForm.setErrors(response.errors)
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
      })
    },
  },
}

/* eslint-disable global-require */
</script>

<style lang="scss">
@import '~@resources/scss/vue/pages/page-auth.scss';
</style>
