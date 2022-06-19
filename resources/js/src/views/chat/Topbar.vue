<template>
  <div class="navbar-container d-flex align-items-center">
    <!-- Nav Menu Toggler -->
    <ul class="nav navbar-nav d-xl-non">
      <li class="nav-item">
        <b-link class="nav-link" @click="openChatUsers">
          <feather-icon icon="MenuIcon" size="21" />
        </b-link>
      </li>

    </ul>

    <!-- Left Col -->
    <div
      class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex"
    >
        <div class="d-flex align-item-center user-nav">
          </div>
          <b-avatar
            size="40"
            variant="light-primary"
            badge
            :text="userAvatarText ? userAvatarText : ''"
            :src="user.avatar ? user.avatar : ''"
            class="badge-minimal ml-1"
            badge-variant="success"
          />
          <p class="user-name font-weight-bolder mb-0">{{ user.first_name }} {{ user.last_name }}</p>
    </div>

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
import { mapActions, mapGetters } from "vuex";
import { can } from '@/auth/authentication'

export default {
  props: ['user'],
    data() {
        return {
            // user: {},
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
  },
  // mounted() {
  //     const getUser = JSON.parse(localStorage.getItem("userData"))
  //     this.user = getUser

  //     const userRole = getUser.user_role;
  //     this.userRole = userRole

  // },
  methods: {
    ...mapActions({ logout: "auth/logout" }),

    imageUrlAlt() {
        this.user.avatar = require("@/assets/images/portrait/small/avatar-s-11.jpg")
    },
    async logoutTrigger(){
        await this.logout()
        this.$router.push({ name: 'login' })
      },
      openChatUsers() {

      }
  },
  computed: {
      userAvatarText() {
          let f = this.user.first_name && this.user.first_name.substring(0, 1);
          let l = this.user.last_name && this.user.last_name.substring(0, 1);
          return f +""+ l
    }
  },
};
</script>
