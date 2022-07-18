<template>
    <div style="height: 60vh">
        <!-- -->
        <b-row>
            <b-col sm="3">
                <b-card>
                    <b-form-input
                        v-if="loggedinUser ? loggedinUser.user_role.id == 3 : ''"
                        id="searchUser"
                        v-model="searchUser"
                        type="search"
                        placeholder="Search Users"
                    />
                    <vue-perfect-scrollbar
                        :settings="perfectScrollbarSettings"
                        class="scroll-area mb-0"
                    >
                        <div class="position-relative" style="height: 60vh" v-if="filteredUsers.length != 0">
                            <div
                                class="d-flex align-item-center cursor-pointer rounded users-list"
                                :class="{ active: chatUser.id === userSelected}"
                                v-for="chatUser in filteredUsers"
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
                        <div v-if="filteredUsers.length == 0"> No user found to chat!</div>
                    </vue-perfect-scrollbar>
                </b-card>
            </b-col>
            <b-col sm="9">
                <b-card>
                    <topbar :user="toUser" @refresh-chat="refreshChat" />

                    <div class="">
                        <vue-perfect-scrollbar
                            :settings="perfectScrollbarSettings"
                            class="user-chats scroll-area p-1 mb-0"
                            id="chat-container"
                            infinite-wrapper
                        >
                            <div v-if="!isChartStarted" class="start-chat position-relative" style="height: 60vh">
                                Start chat
                            </div>

                            <div
                                class="position-relative"
                                v-if="isChartStarted"
                                style="height: 60vh"
                            >
                                <infinite-loading @distance="1"  direction="top" :identifier="infiniteId" @infinite="handleLoadMore">
                                    <div slot="spinner">Loading...</div>
                                    <div slot="no-more">No more messages!</div>
                                    <div slot="no-results">No messages!</div>
                                </infinite-loading>

                                <div
                                    class="d-flex align-item-center mb-1 mt-1 pb-1"
                                    :class="chat.my_message ? 'my-chat flex-row-reverse text-right' : ''"
                                    v-for="chat in chats"
                                    :key="chat.id"
                                >
                                    <b-avatar
                                        size="32"
                                        variant="light-primary"
                                        :class="chat.my_message ? 'ml-1' : 'mr-1'"
                                    />
                                    <div>
                                    <div class="chat-info col shadow p-1 bg-white rounded"
                                        :class="chat.my_message ? 'my-message bg-success bg-lighten-1' : ''">
                                        <div :class="chat.my_message ? 'd-flex flex-row-reverse' : ''">
                                            <h5 class="mb-0 p-0 d-inline"
                                                :class="chat.my_message ? 'ml-2' : 'mr-2'"
                                            >
                                                {{ chat.from_user }}
                                            </h5>
                                            <span class="text-muted font-small-2">
                                                {{
                                                    new Date(
                                                        chat.created_at
                                                    ).toDateString()
                                                }}
                                            </span>
                                        </div>
                                        <p class="card-text text-break">
                                            {{ chat.message }}
                                        </p>
                                    </div>
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
                                <!-- <b-button
                                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                                    variant="primary"
                                    @click="refreshChat"
                                >
                                    <feather-icon
                                        icon="RefreshCwIcon"
                                    />
                                    <b-spinner small v-if="isLoading" /> -->
                                <!-- </b-button>  -->
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
import InfiniteLoading from 'vue-infinite-loading'
import axios from "axios";

export default {
    data() {
        return {
            loggedinUserRole: '',
            loggedinUser: '',
            chatUsers: [],
            isChartStarted: false,
            isChatLoading: false,
            userSelected: false,

            chats: [],
            message: "",
            toUserId: 0,
            toUser: {},

            perfectScrollbarSettings: {
                maxScrollbarLength: 60,
                height: 10,
            },

            searchUser: '',
            page: 1,
            infiniteId: +new Date(),
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
        InfiniteLoading,
    },
    methods: {
        ...mapActions({
            loadAccounts: "account/loadAccounts",
            loadChats: "chat/loadChats",
            sendMessage: "chat/sendMessage",
        }),

        handleLoadMore($state) {
            this.page = this.page + 1;

            this.loadChats( { toUserId: this.toUserId, pageNo: this.page } )
                .then((response) => {
                    if(response.success) {
                        this.chats.unshift(...response.data)
                        $state.loaded();
                    } else {

                        $state.complete();
                    }
                })
                .catch((error) => {
                    console.log("chat loadmore error" + error);
                });

        },

        startChat(ChatThisUser) {
            this.chats = [] // empty chat on selection/change of user
            this.page = 1
             this.infiniteId += 1
            this.isChartStarted = true;
            this.userSelected = ChatThisUser.id // changing message data
            this.toUserId = ChatThisUser.id; // sending for message
            // load messages of selected user
            this.loadChats( { toUserId: ChatThisUser.id, pageNo: this.page } )
                .then((response) => {
                    if(response.success) { this.chats = response.data }
                    this.scrollToEnd()
                })
                .catch( error => console.log(error) );

            this.toUser = ChatThisUser;
        },

        refreshChat() {
            this.chats = [] // empty chat on selection/change of user
            this.page = 1
             this.infiniteId += 1
            this.isChartStarted = true;
            this.loadChats( { toUserId: this.toUserId, pageNo: this.page } )
                .then((response) => {
                    if(response.success) { this.chats = response.data }
                    this.scrollToEnd()
                })
                .catch( error => console.log(error) );
        },

        // Add commments
        sendMessageTrigger() {
            let chatData = new FormData();
            chatData.append("to_user_id", this.toUserId);
            chatData.append("message", this.message);

            this.sendMessage(chatData)
                .then((response) => {
                    if (response.success) {
                        this.chats.push(response.data)
                        this.message = "";
                    } else {
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
                    this.$nextTick(() => {
                        // this.startChat(this.toUser)
                     this.scrollToEnd()
                    });
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
        scrollToEnd() {
            var container = this.$el.querySelector("#chat-container");
            container.scrollTop = container.scrollHeight;
        },
    },
    computed: {
        ...mapGetters({
            isLoading: "chat/getIsLoading",
            isDataLoading: "chat/getIsDataLoading",
            // chats: "chat/getChats",
        }),

        loggedinUserAvatar() {
            return JSON.parse(localStorage.getItem('userData')).avatar
        },

        reverseChat() {
            return this.chats.slice().reverse();
        },

        filteredUsers() {
            return this.chatUsers.filter(user => {
                return user.first_name.toLowerCase().indexOf(this.searchUser.toLowerCase()) > -1
            })
        }
    },
    mounted() {
        // getting loggedin user
        const getUser = JSON.parse(localStorage.getItem("userData"));
        this.loggedinUser = getUser
        const userRole = getUser.user_role;
        this.loggedinUserRole = userRole

        // getting lsiting
        this.loadAccounts()
            .then((response) => {
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
    directives: {
        Ripple,
    },
};
</script>

<style></style>
