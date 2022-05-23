<template>
  <div>
    <!-- Header -->
    <b-row class="mb-4">
      <b-col md="6" sm="12">
        <b-card-text> <h1>Edit Account</h1> </b-card-text>
      </b-col>
      <b-col md="6" sm="12">
        <div class="text-right">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            :to="{ name: 'accounts' }"
          >
            Update
          </b-button>
        </div>
      </b-col>
    </b-row>

    <!-- Cutsom account form -->
    <b-row>
      <b-col md="4">
        <b-card>
          <!-- media -->
          <b-media no-body>
            <b-media-aside>
              <b-link>
                <b-img
                  ref="previewEl"
                  rounded
                  :src="account.avatar"
                  height="80"
                />
              </b-link>
              <!--/ avatar -->
            </b-media-aside>

            <b-media-body class="mt-75 ml-75">
              <h3>Account Name</h3>
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
                v-model="profileFile"
                accept=".jpg, .png, .gif"
                :hidden="true"
                plain
                @input="inputImageRenderer"
              />
              <!--/ upload button -->

              <b-card-text
                >Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text
              >
            </b-media-body>
          </b-media>
          <!--/ media -->
        </b-card>
      </b-col>
      <b-col md="8">
        <b-card>
          <!-- form -->
          <b-form class="mt-2">
            <b-row>
              <b-col sm="6">
                <b-form-group label="First Name" label-for="account-name">
                  <b-form-input
                    v-model="account.firstName"
                    name="name"
                    placeholder="First Name"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="6">
                <b-form-group label="Last Name" label-for="account-name">
                  <b-form-input
                    v-model="account.lastName"
                    name="name"
                    placeholder="Last Name"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="6">
                <b-form-group label="Username" label-for="account-username">
                  <b-form-input
                    v-model="account.username"
                    placeholder="Username"
                    name="username"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="6">
                <b-form-group label="E-mail" label-for="account-e-mail">
                  <b-form-input
                    v-model="account.email"
                    name="email"
                    placeholder="Email"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="6">
                <b-form-group label="Phone" label-for="account-e-phone">
                  <b-form-input
                    v-model="account.phone"
                    name="phone"
                    placeholder="Phone"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="6">
                <b-form-group label="Company" label-for="account-company">
                  <b-form-input
                    v-model="account.company"
                    name="company"
                    placeholder="Company name"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="4">
                <b-form-group label="Country" label-for="country">
                  <b-form-input id="country" placeholder="Country" required />
                </b-form-group>
              </b-col>
              <b-col sm="4">
                <b-form-group label="State" label-for="state">
                  <b-form-select
                    v-model="stateVal"
                    :options="state"
                    id="state"
                  />
                </b-form-group>
              </b-col>
              <b-col sm="4">
                <b-form-group label="District" label-for="district">
                  <b-form-select
                    v-model="districtVal"
                    :options="district"
                    id="district"
                  />
                </b-form-group>
              </b-col>

              <!-- alert -->
              <b-col cols="12" class="mt-75">
                <b-alert show variant="warning" class="mb-50">
                  <h4 class="alert-heading">
                    Your email is not confirmed. Please check your inbox.
                  </h4>
                  <div class="alert-body">
                    <b-link class="alert-link"> Resend confirmation </b-link>
                  </div>
                </b-alert>
              </b-col>
              <!--/ alert -->

              <b-col cols="12">
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="mt-2 mr-1"
                >
                  Save changes
                </b-button>
              </b-col>
            </b-row>
          </b-form>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
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
  BAlert,
  BMedia,
  BMediaAside,
  BMediaBody,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { useInputImageRenderer } from "@core/comp-functions/forms/form-utils";
import { ref } from "@vue/composition-api";

export default {
  components: {
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
    BAlert,
    BMedia,
    BMediaAside,
    BMediaBody,
  },
  data() {
    return {
      account: {
        avatar: require("@/assets/images/portrait/small/avatar-s-11.jpg"),
        username: "johndoe",
        fullName: "John Doe",
        email: "granger007@hogward.com",
        location: "Crystal Technologies",
        phone: "321321321"
      },
      profileFile: null,
    };
  },
  methods: {
    resetForm() {
      this.account = JSON.parse(JSON.stringify(this.generalData));
    },
  },
  setup() {
    const refInputEl = ref(null);
    const previewEl = ref(null);

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, previewEl);

    return {
      refInputEl,
      previewEl,
      inputImageRenderer,
    };
  },
  directives: {
    Ripple,
  },
};
</script>

<style>
</style>
