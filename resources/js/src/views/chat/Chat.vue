<template>
    <div>
        <!-- -->
        <b-card>
            <b-row>
                <b-col>

                <div class="">
                    <vue-perfect-scrollbar
                        :settings="perfectScrollbarSettings"
                        class="user-chats scroll-area p-1 mb-0 mt-2"
                    >
                        <div
                            class="chats position-relative"
                            style="height: 70vh"
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
                                    src=""
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
                                        {{ chat.to_user }}
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

                    <div class="d-flex align-item-center p-1">
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
                            @click="addChatTrigger"
                        >
                            <feather-icon icon="SendIcon" v-if="!isLoading" />
                            <b-spinner small v-if="isLoading" />
                        </b-button>
                    </div>

                </div>

                </b-col>
            </b-row>
        </b-card>
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
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { can } from "@/auth/authentication.js";

export default {
    data() {
        return {

            message: "",
            to_user_id: 1,

            statuses_color,

            can,

            perfectScrollbarSettings: {
                maxScrollbarLength: 60,
                height: 10,
            },
            document_type_options: [
                { text: "Legal Document", value: "legal" },
                { text: "Payment Document", value: "finance" },
            ],
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
    },
    methods: {
        ...mapActions({
            loadChats: "chat/loadChats",
            addChat: "chat/addChat",
        }),


        // Add commments
        addChatTrigger() {
            let chatData = new FormData();
            chatData.append("to_user_id", this.to_user_id);
            chatData.append("message", this.message);

            this.addChat(chatData)
                .then((response) => {
                    if (response.success) {
                        console.log(response.data);
                        this.message = "";
                        // this.$toast({
                        //     component: ToastificationContent,
                        //     props: {
                        //         title: response.message,
                        //         icon: "EditIcon",
                        //         variant: "success",
                        //     },
                        // });
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
    },
    computed: {
        ...mapGetters({
            isLoading: "chat/getIsLoading",
            isDataLoading: "chat/getIsDataLoading",
            chats: "chat/getChats",
        }),
    },
    created() {



        this.loadChats();
        //     .then((response) => {
        //     if (response.success) {
        //         console.log(response);
        //         this.chats = response.data;
        //     } else {
        //         this.$toast({
        //             component: ToastificationContent,
        //             props: {
        //                 title: response.message,
        //                 icon: "EditIcon",
        //                 variant: "danger",
        //             },
        //         });
        //     }
        // })
        // .catch((error) => {
        //     console.log(error);
        //     this.$toast({
        //         component: ToastificationContent,
        //         props: {
        //             title: "Error while loading",
        //             icon: "EditIcon",
        //             variant: "danger",
        //         },
        //     });
        // });
    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
