<template>
    <b-nav-item-dropdown
        class="dropdown-notification mr-25"
        menu-class="dropdown-menu-media"
        right
    >
        <template #button-content>
            <feather-icon
                :badge="newNotifisCount"
                badge-classes="bg-danger"
                class="text-body"
                icon="BellIcon"
                size="21"
            />
        </template>

        <!-- Header -->
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
                <b-badge pill variant="light-primary">
                    {{ newNotifisCount }} New
                </b-badge>
            </div>
        </li>

        <!-- Notifications -->
        <vue-perfect-scrollbar
            :settings="perfectScrollbarSettings"
            class="scrollable-container media-list scroll-area"
            tagname="li"
        >
            <!-- Account Notification -->
            <b-link
                v-for="ntf in notifications"
                :key="ntf.id"

            >
                <b-media @click.prevent="seenNotificationTrigger(ntf.id)" :class=" ntf.seen === 1 ? '' : 'bg-primary bg-lighten-5'">
                    <template #aside>
                        <b-avatar
                            size="32"
                            variant="light-primary"
                        />
                    </template>
                    <p class="media-heading">
                        <span class="font-weight-bolder">
                            {{ ntf.title }}
                        </span>
                    </p>
                    <small class="notification-text"> {{ ntf.message }}</small>
                </b-media>
            </b-link>
        </vue-perfect-scrollbar>

        <!-- Cart Footer -->
        <!-- <li class="dropdown-menu-footer"><b-button
      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        class="mb-1"
      variant="primary"
      block
    >Read all notifications</b-button>
    </li> -->
    </b-nav-item-dropdown>
</template>

<script>
import {
    BNavItemDropdown,
    BBadge,
    BMedia,
    BLink,
    BAvatar,
    BButton,
    BFormCheckbox,
} from "bootstrap-vue";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import Ripple from "vue-ripple-directive";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { mapActions, mapGetters } from "vuex";

export default {
    data() {
        return {
            perfectScrollbarSettings: {
                maxScrollbarLength: 60,
                wheelPropagation: false,
            },
        };
    },
    components: {
        BNavItemDropdown,
        BBadge,
        BMedia,
        BLink,
        BAvatar,
        VuePerfectScrollbar,
        BButton,
        BFormCheckbox,
    },
    directives: {
        Ripple,
    },
    computed: {
        ...mapGetters({
            isLoading: "dashboard/getIsLoading",
            isDataLoading: "dashboard/getIsDataLoading",
            notifications: "dashboard/getNotifications",
            newNotifisCount: "dashboard/getNewNotifications",
        }),
    },
    methods: {
        ...mapActions({ loadNotifications: "dashboard/loadNotifications", seenNotifications: "dashboard/seenNotifications", }),

        seenNotificationTrigger( notiId ) {
            this.seenNotifications({ id: notiId })
                .then((response) => {
                    console.log(response);
                    if (response.success) {
                        this.loadNotifications();
                        this.$toast({
                            component: ToastificationContent,
                            props: { title: response.message, icon: "EditIcon", variant: "success" },
                        });
                    } else {
                        console.log(response);
                        this.$toast({
                            component: ToastificationContent,
                            props: { title: response.message,icon: "EditIcon",variant: "danger" },
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast({
                        component: ToastificationContent,
                        props: { title: "Error While Adding!", icon: "EditIcon", variant: "danger" },
                    });
                });

        },


    },
    mounted() {
        //    getting notifications
        this.loadNotifications();
    },
};
</script>

<style></style>
