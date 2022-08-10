<template>
  <div>
    <!-- Header -->
    <b-row class="mb-2">
      <b-col md="6" sm="12">
        <b-card-text> <h1>Settings</h1> </b-card-text>
      </b-col>
    </b-row>
    <!-- Tab Button -->
    <setting-tab-button> </setting-tab-button>

    <b-card>
      <b-row>
        <b-col cols="4">
          <h5 class="mx-1 mb-2">Notification</h5>
          <b-col cols="12" class="mb-2">
            <b-form-checkbox
              id="accountSwitch1"
              :checked="notification.commentOnArticle"
              name="check-button"
              switch
              inline
            >
              <span>Email</span>
            </b-form-checkbox>
          </b-col>
          <b-col cols="12" class="mb-2">
            <b-form-checkbox
              id="accountSwitch2"
              :checked="notification.AnswerOnForm"
              name="check-button"
              switch
              inline
            >
              <span>Message</span>
            </b-form-checkbox>
          </b-col>
          </b-col>

        <!-- buttons -->
        <b-col cols="12">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            class="mb-1 mr-1 mt-1"
          >
            Save changes
          </b-button>
        </b-col>
        <!--/ buttons -->
      </b-row>
    </b-card>
    <!-- Password setting -->
    <password-setting></password-setting>
  </div>
</template>

<script>
import { BButton, BRow, BCol, BCard, BCardText, BFormCheckbox } from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import SettingTabButton from "./SettingTabButton.vue";
import PasswordSetting from "./PasswordSetting.vue";

export default {
  components: {
    BButton,
    BRow,
    BCol,
    BCard,
    BCardText,
    BFormCheckbox,
    SettingTabButton,
    PasswordSetting,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      notification: {
        commentOnArticle: true,
        AnswerOnForm: true,
        followMe: false,
        newAnnouncements: true,
        productUpdates: true,
        blogDigest: false,
      },
    };
  },
};
</script>
