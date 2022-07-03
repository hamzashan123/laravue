<template>
    <div>
        <!-- -->
        <b-row>
            <b-col sm="3">
                <b-card>
                    <vue-perfect-scrollbar
                        :settings="perfectScrollbarSettings"
                        class="scroll-area mb-0"
                    >
                        <div class="position-relative">
                            <div
                                class="d-flex align-item-center cursor-pointer rounded users-list"
                                :class="{ active: chatUser.id === userSelected}"
                                v-for="chatUser in chatUsers"
                                :key="chatUser.id"
                            >
                                <div @click="startChat(chatUser)">
                                    <b-avatar
                                        size="32"
                                        :variant=" chatUser.id === userSelected ? 'light-default' : 'light-primary'"
                                        class="mr-1 border"
                                        :src="chatUser.avatar"
                                    />
                                    {{ chatUser.user_name }}
                                </div>
                            </div>
                        </div>
                    </vue-perfect-scrollbar>
                </b-card>
            </b-col>
            <b-col sm="9">
                <b-card>
                    <topbar :user="toUser" />

                    <div class="">
                        <vue-perfect-scrollbar
                            :settings="perfectScrollbarSettings"
                            class="user-chats scroll-area p-1 mb-0"
                        >
                            <div v-if="!isChartStarted" class="start-chat" style="height: 60vh">
                                Start chat
                            </div>
                            <div
                                class="chats position-relative"
                                v-if="isChartStarted"
                                style="height: 60vh"
                            >
                                <div
                                    class="d-flex align-item-center mb-1 mt-1 pb-1"
                                    v-for="chat in chats"
                                    :key="chat.id"
                                >
                                    <b-avatar
                                        size="32"
                                        variant="light-primary"
                                        class="mr-1"
                                    />
                                    <div
                                        class="chat-info col shadow p-1 bg-white rounded"
                                        :class="
                                            chat.my_message
                                                ? 'bg-primary bg-lighten-5'
                                                : ''
                                        "
                                    >
                                        <h5 class="mb-0 p-0 mr-2 d-inline">
                                            {{ chat.from_user }}
                                        </h5>
                                        <small>
                                            {{
                                                new Date(
                                                    chat.created_at
                                                ).toDateString()
                                            }}
                                        </small>
                                        <p class="card-text">
                                            {{ chat.message }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </vue-perfect-scrollbar>

                        <div v-if="isChartStarted">
                            <b-form
                                @submit.prevent="sendMessageTrigger"
                                class="d-flex align-item-center p-1"
                            >
                                <b-form-input
                                    v-model="message"
                                    id="message"
                                    placeholder="Write..."
                                    rows="3"
                                    class="mr-1"
                                />
                                <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    type="submit"
                                    variant="primary"
                                >
                                    <feather-icon
                                        icon="SendIcon"
                                        v-if="!isLoading"
                                    />
                                    <b-spinner small v-if="isLoading" />
                                </b-button>
                            </b-form>
                        </div>
                    </div>
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
    BTabs,
    BTab,
    BFormRadioGroup,
    BAvatar,
    BSpinner,
    BBadge,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import Topbar from "./Topbar.vue";
import { mapActions, mapGetters } from "vuex";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
    data() {
        return {
            chatUsers: {},
            isChartStarted: false,
            isChatLoading: false,
            userSelected: false,


            message: "",
            toUserId: 0,
            toUser: {},

            perfectScrollbarSettings: {
                maxScrollbarLength: 60,
                height: 10,
            },
        };
    },
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
        BTabs,
        BTab,
        BFormRadioGroup,
        BAvatar,
        BSpinner,
        BBadge,
        VuePerfectScrollbar,
        Topbar,
    },
    methods: {
        ...mapActions({
            loadAccounts: "account/loadAccounts",
            loadChats: "chat/loadChats",
            sendMessage: "chat/sendMessage",
        }),

        startChat(ChatThisUser) {
            console.log(ChatThisUser.id);
            this.isChartStarted = true;
            this.userSelected = ChatThisUser.id // changing message data
            this.toUserId = ChatThisUser.id; // sending for message
            this.loadChats( { to_user_id: ChatThisUser.id } );
            this.toUser = ChatThisUser;
        },

        // Add commments
        sendMessageTrigger() {
            let chatData = new FormData();
            chatData.append("to_user_id", this.toUserId);
            chatData.append("message", this.message);

            this.sendMessage(chatData)
                .then((response) => {
                    if (response.success) {
                        this.loadChats( { to_user_id: this.toUserId } );
                        console.log(response.data);
                        this.message = "";
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
                        this.message = "";
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
        },
        scrollToEnd: function () {
            // scroll to the start of the last message
            this.$el.scrollTop = this.$el.lastElementChild.offsetTop;
        },
    },
    computed: {
        ...mapGetters({
            isLoading: "chat/getIsLoading",
            isDataLoading: "chat/getIsDataLoading",
            chats: "chat/getChats",
        }),

        loggedinUserAvatar() {
            return JSON.parse(localStorage.getItem('userData')).avatar
        },

        reverseChat() {
            return this.chats.slice().reverse();
        },
    },
    created() {
        // getting lsiting
        this.loadAccounts()
            .then((response) => {
                console.log(response);
                if (response.success) {
                    this.chatUsers = response.user;
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
            .catch((error) => {
                console.log(error);
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error while loading",
                        icon: "EditIcon",
                        variant: "danger",
                    },
                });
            });
    },
    updated() {
        this.$nextTick(() => this.scrollToEnd());
    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
