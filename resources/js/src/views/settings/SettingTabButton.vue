<template>
  <b-row class="mb-2">
    <b-col>
      <b-button
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
        variant="flat-primary"
        :class=" this.$router.history.current.path == '/settings/account' ? 'active ' : 'mr-1 ' "
        :to="{ name: 'settings' }"
      >
        Settings
      </b-button>
      <b-button
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
        variant="flat-primary"
        :class=" this.$router.history.current.path == '/settings/profile' ? 'active ' : 'mr-1 ' "
        :to="{ name: 'profile-setting' }"
      >
        Profile Setting
      </b-button>
    </b-col>
  </b-row>
</template>

<script>
import { BButton, BRow, BCol } from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

export default {
  components: {
    BButton,
    BRow,
    BCol,
  },
  directives: {
    Ripple,
  },
};
</script>
