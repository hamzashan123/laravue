<template>
  <div class="navbar-container d-flex content align-items-center">
    <!-- Nav Menu Toggler -->
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item">
        <b-link class="nav-link" @click="toggleVerticalMenuActive">
          <feather-icon icon="MenuIcon" size="21" />
        </b-link>
      </li>

    </ul>

    <!-- Left Col -->
    <div
      class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex"
    >
      <dark-Toggler class="d-none d-lg-block" />
    </div>

    <b-navbar-nav class="nav align-items-center ml-auto">
      <notification-dropdown />
      <b-nav-item-dropdown
        right
        toggle-class="d-flex align-items-center dropdown-user-link"
        class="dropdown-user"
      >
        <template #button-content>
          <div class="d-sm-flex d-none user-nav">
            <p class="user-name font-weight-bolder mb-0">{{ user.first_name }} {{ user.last_name }}</p>
            <span class="user-status">{{ userRole.role }}</span>
          </div>
          <b-avatar
            size="40"
            variant="light-primary"
            badge
            :text="userAvatarText"
            :src="user.avatar"
            class="badge-minimal"
            badge-variant="success"
          />
        </template>

        <b-dropdown-item link-class="d-flex align-items-center" :to="{name: 'profile-setting' }">
          <feather-icon size="16" icon="UserIcon" class="mr-50" />
          <span>Profile</span>
        </b-dropdown-item>

        <b-dropdown-divider />

        <b-dropdown-item link-class="d-flex align-items-center" @click="logoutTrigger">
          <feather-icon size="16" icon="LogOutIcon" class="mr-50" />
          <span>Logout</span>
        </b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </div>
</template>

<script>
import {
  BLink,
  BNavbarNav,
  BNavItemDropdown,
  BDropdownItem,
  BDropdownDivider,
  BAvatar,
} from "bootstrap-vue";
import DarkToggler from "@core/layouts/components/app-navbar/components/DarkToggler.vue";
import NotificationDropdown from "./NotificationDropdown.vue";
import { mapActions, mapGetters } from "vuex";
import { can } from '@/auth/authentication'

export default {
    data() {
        return {
            user: {},
            userRole: {},
            can
        }
    },
  components: {
    BLink,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar,

    // Navbar Components
    DarkToggler,
    NotificationDropdown,
  },
  mounted() {
      const getUser = JSON.parse(localStorage.getItem("userData"))
      this.user = getUser

      const userRole = getUser.user_role;
      this.userRole = userRole

  },
  methods: {
    ...mapActions({ logout: "auth/logout" }),

    imageUrlAlt() {
        this.user.avatar = require("@/assets/images/portrait/small/avatar-s-11.jpg")
    },
    async logoutTrigger(){
        await this.logout()
        this.$router.push({ name: 'login' })
      }
  },
  computed: {
      userAvatarText() {
          let f = this.user.first_name && this.user.first_name.substring(0, 1);
          let l = this.user.last_name && this.user.last_name.substring(0, 1);
          return f +""+ l
    }
  },
  props: {
    toggleVerticalMenuActive: {
      type: Function,
      default: () => {},
    },
  },
};
</script>
