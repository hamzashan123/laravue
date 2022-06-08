<template>
    <div>
        <!-- Header -->
        <!-- <b-card> -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Add documents on {{ listing.title }}</h1>
                     <b-badge :variant="statuses_color[1][listing.status]">
                        {{ statuses_color[0][listing.status] }}
                     </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'contracts' }"
                    >
                        Back to Contracts
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'contracts.view', params: { contractId: 1 } }"
                    >
                        See Details
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <!-- </b-card> -->

        <!-- LEgal and Payment Status -->
        <b-card>
                <b-row>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Client's Legal
                        </h4>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Status  </h5>
                            </div>
                            <div class="col">
                                <b-form-input
                                    value="25%"
                                    id="target_completion_dateto"
                                    placeholder="Date To"
                                    class="mb-2"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Documents  </h5>
                            </div>
                            <div class="col">
                                <div v-for="(lcd, idx) in legal_client_documents" :key="idx">

                                    <b-avatar
                                    variant="light-dark"
                                    square
                                    :text="lcd.legal_document_path.substr(lcd.legal_document_path.length - 3)"
                                    size="md"
                                    />
                                    <b-button
                                    v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                    variant="outline-dark"
                                    size="sm"
                                    :href="lcd.legal_document_path"
                                    >
                                    {{ lcd.legal_document_name }}
                                    </b-button>
                                </div>

                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Contractor's Legal
                        </h4>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Status  </h5>
                            </div>
                            <div class="col">
                                <b-form-input
                                    value="25%"
                                    id="target_completion_dateto"
                                    placeholder="Date To"
                                    class="mb-2"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Documents  </h5>
                            </div>
                            <div class="col">
                                <div v-for="(lcd, idx) in legal_contractor_documents" :key="idx">

                                    <b-avatar
                                    variant="light-dark"
                                    square
                                    :text="lcd.legal_document_path.substr(lcd.legal_document_path.length - 3)"
                                    size="md"
                                    />
                                    <b-button
                                    v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                    variant="outline-dark"
                                    size="sm"
                                    :href="lcd.legal_document_path"
                                    >
                                    {{ lcd.legal_document_name }}
                                    </b-button>
                                </div>

                            </div>
                        </div>
                    </b-col>
                </b-row>
        </b-card>

        <b-card>
                <b-row>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Client's Payment
                        </h4>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Status  </h5>
                            </div>
                            <div class="col">
                                <b-form-input
                                    value="25%"
                                    id="target_completion_dateto"
                                    placeholder="Date To"
                                    class="mb-2"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Documents  </h5>
                            </div>
                            <div class="col">
                                <div v-for="(lcd, idx) in finance_client_documents" :key="idx">

                                    <b-avatar
                                    variant="light-dark"
                                    square
                                    :text="lcd.legal_document_path.substr(lcd.legal_document_path.length - 3)"
                                    size="md"
                                    />
                                    <b-button
                                    v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                    variant="outline-dark"
                                    size="sm"
                                    :href="lcd.legal_document_path"
                                    >
                                    {{ lcd.legal_document_name }}
                                    </b-button>
                                </div>

                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Contractor's Payment
                        </h4>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Status  </h5>
                            </div>
                            <div class="col">
                                <b-form-input
                                    value="25%"
                                    id="target_completion_dateto"
                                    placeholder="Date To"
                                    class="mb-2"
                                    disabled
                                />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <h5 class="mb-2">  Documents  </h5>
                            </div>
                            <div class="col">
                                <div v-for="(lcd, idx) in finance_contractor_documents" :key="idx">

                                    <b-avatar
                                    variant="light-dark"
                                    square
                                    :text="lcd.legal_document_path.substr(lcd.legal_document_path.length - 3)"
                                    size="md"
                                    />
                                    <b-button
                                    v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                    variant="outline-dark"
                                    size="sm"
                                    target="_blank"
                                    :href="lcd.legal_document_path"
                                    >
                                    {{ lcd.legal_document_name }}
                                    </b-button>
                                </div>

                            </div>
                        </div>
                    </b-col>
                </b-row>
        </b-card>

        <!-- Images and Detail -->
        <b-card>
            <b-form @submit.prevent>
                <b-row>
                    <!-- Tabs -->
                    <b-col md="6" class="mb-2">
                        <b-tabs>
                            <b-tab active>
                                <template #title>
                                    <feather-icon icon="HomeIcon" />
                                    <span>Client</span>
                                </template>

                                <div class="mt-2">
                                    <b-form-group
                                        label="Select document type:"
                                        label-for="document-type"
                                    >
                                        <b-form-radio-group
                                            v-model="client_documents.document_type"
                                            :options="document_type_options"
                                            class=""
                                            name="document-type"
                                        >
                                        </b-form-radio-group>
                                    </b-form-group>

                                    <b-row>
                                        <b-col md="10">
                                            <b-form-group
                                                label="Note"
                                                label-for="Note"
                                            >
                                                <b-form-input
                                                    id="Note"
                                                    v-model="client_documents.notes"
                                                    placeholder="Add note for document"
                                                />
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="2">
                                            <b-form-group
                                                label="Percetange"
                                                label-for="Percetange"
                                            >
                                                <b-form-input
                                                    v-model="client_documents.percentage"
                                                    id="Percetange"
                                                    placeholder="Add number only"
                                                />
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group
                                                label="Upload documents"
                                                label-for="doc"
                                            >
                                                <b-form-file
                                                    v-model="client_documents.legal_documents"
                                                    placeholder="Upload Document"
                                                    drop-placeholder="Drop file here..."
                                                    multiple
                                                    accept=".jpg, .pdf, .doc"
                                                />
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group
                                                label="Select Date"
                                                label-for="doc"
                                            >
                                                <b-form-datepicker
                                                    v-model="client_documents.legal_document_date"
                                                    placeholder="Select From Date"
                                                    id="target_completion_datefrom"
                                                    class="mb-1 p-0"
                                                    name="target_completion_datefrom"
                                                />
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-col class="text-right">
                                        <b-button
                                            v-ripple.400="'rgba(255, 255, 255, 0.15)' "
                                            type="submit"
                                            variant="primary"
                                            @click="uploadClientDocTrigger"
                                        >
                                            Save Details
                                            <b-spinner small v-if="isLoading" />
                                        </b-button>
                                    </b-col>
                                </div>
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon icon="ToolIcon" />
                                    <span>Conractor</span>
                                </template>

                                <div class="mt-2">
                                    <b-form-group
                                        label="Select document type:"
                                        label-for="document-type"
                                    >
                                        <b-form-radio-group
                                            v-model="contractor_documents.document_type"
                                            :options="document_type_options"
                                            class=""
                                            name="document-type"
                                        >
                                        </b-form-radio-group>
                                    </b-form-group>

                                    <b-row>
                                        <b-col md="10">
                                            <b-form-group
                                                label="Note"
                                                label-for="Note"
                                            >
                                                <b-form-input
                                                    id="Note"
                                                    v-model="contractor_documents.notes"
                                                    placeholder="Add note for document"
                                                />
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="2">
                                            <b-form-group
                                                label="Percetange"
                                                label-for="Percetange"
                                            >
                                                <b-form-input
                                                    v-model="contractor_documents.percentage"
                                                    id="Percetange"
                                                    placeholder="Add number only"
                                                />
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group
                                                label="Upload documents"
                                                label-for="doc"
                                            >
                                                <b-form-file
                                                    v-model="contractor_documents.legal_documents"
                                                    placeholder="Upload Document"
                                                    drop-placeholder="Drop file here..."
                                                    multiple
                                                    accept=".jpg, .pdf, .doc"
                                                />
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group
                                                label="Select Date"
                                                label-for="doc"
                                            >
                                                <b-form-datepicker
                                                    v-model="contractor_documents.legal_document_date"
                                                    placeholder="Select From Date"
                                                    id="target_completion_datefrom"
                                                    class="mb-1 p-0"
                                                    name="target_completion_datefrom"
                                                />
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-col class="text-right">
                                        <b-button
                                            v-ripple.400="
                                                'rgba(255, 255, 255, 0.15)'
                                            "
                                            type="submit"
                                            variant="primary"
                                            @click="uploadContractorDocTrigger"
                                        >
                                            Save Details
                                            <b-spinner small v-if="isLoading" />
                                        </b-button>
                                    </b-col>
                                </div>
                            </b-tab>
                            <b-tab>
                                <template #title>
                                    <feather-icon icon="MessageCircleIcon" />
                                    <span>Comment</span>
                                </template>
                                <div class="mb-2">
                                    <b-form-group
                                        label="Add your Comment"
                                        label-for="Percetange"
                                    >
                                        <b-form-textarea
                                            id="listingDetails"
                                            placeholder="Comment"
                                            rows="3"
                                        />
                                    </b-form-group>
                                    <b-col class="text-right">
                                        <b-button
                                            v-ripple.400="
                                                'rgba(255, 255, 255, 0.15)'
                                            "
                                            type="submit"
                                            variant="primary"
                                        >
                                            Add Comment
                                        </b-button>
                                    </b-col>
                                        <vue-perfect-scrollbar
                                            :settings="perfectScrollbarSettings"
                                            class="user-chats scroll-area border m-1 p-1"
                                            >
                                    <div class="comments position-relative" style="height: 60vh">
                                            <div class="d-flex align-item-center mb-1 mt-1">
                                                <b-avatar
                                                    size="40"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div class="chat-info flex-grow-1">
                                                    <h5 class="mb-0">Ameen</h5>
                                                    <p class="card-text ">
                                                        Here is my message
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-item-center mb-1 mt-1">
                                                <b-avatar
                                                    size="40"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div class="chat-info flex-grow-1">
                                                    <h5 class="mb-0">Hamza</h5>
                                                    <p class="card-text ">
                                                        Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-item-center mb-1 mt-1">
                                                <b-avatar
                                                    size="40"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div class="chat-info flex-grow-1">
                                                    <h5 class="mb-0">Hamza</h5>
                                                    <p class="card-text">
                                                        Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-item-center mb-1 mt-1">
                                                <b-avatar
                                                    size="40"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div class="chat-info flex-grow-1">
                                                    <h5 class="mb-0">Hamza</h5>
                                                    <p class="card-text ">
                                                        Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-item-center mb-1 mt-1">
                                                <b-avatar
                                                    size="40"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div class="chat-info flex-grow-1">
                                                    <h5 class="mb-0">Hamza</h5>
                                                    <p class="card-text ">
                                                        Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message. Here is some anther message.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-item-center mb-1 mt-1">
                                                <b-avatar
                                                    size="40"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div class="chat-info flex-grow-1">
                                                    <h5 class="mb-0">Touqeer    </h5>
                                                    <p class="card-text ">
                                                        Here is my message
                                                    </p>
                                                </div>
                                            </div>

                                    </div>
                                        </vue-perfect-scrollbar>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </b-col>
                    <!-- Details Form -->
                    <b-col md="6" class="mb-2">
                        <h4 class="mb-2">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Listing Details
                        </h4>
                        <b-form-group
                            label="Name your listing"
                            label-for="listingname"
                        >
                            <b-form-input
                                id="listingname"
                                v-model="listing.title"
                                placeholder="Name"
                                disabled
                            />
                        </b-form-group>

                        <div class="mb-2">
                            <label for="listingDetails">Description</label>
                            <b-form-textarea
                                id="listingDetails"
                                v-model="listing.description"
                                placeholder="Listing Details"
                                rows="3"
                                disabled
                            />
                        </div>
                        <b-row>
                            <b-col lg="6" class="mb-2">
                                <b-form-input
                                    id="gmap-autocompelte"
                                    placeholder="Search Address"
                                    disabled
                                />
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6999.66461408364!2d76.92634623988648!3d28.69466251428776!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d096a6dcc31c7%3A0xbbcc18016f20e440!2sModicare%20Store!5e0!3m2!1sen!2s!4v1652653238809!5m2!1sen!2s"
                                    width="100%"
                                    height="300"
                                    style="border: 0"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                ></iframe>
                            </b-col>
                            <b-col lg="6">
                                <b-form-group
                                    label="Address Line 1 *"
                                    label-for="address-line-1"
                                >
                                    <b-form-input
                                        v-model="listing.address_line1"
                                        id="address-line-1"
                                        placeholder="Address Line 1 *"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Address Line 2 *"
                                    label-for="address-line-2"
                                >
                                    <b-form-input
                                        v-model="listing.address_line2"
                                        id="address-line-2"
                                        placeholder="Address Line 2 *"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="Country"
                                    label-for="country"
                                >
                                    <b-form-input
                                        id="country"
                                        placeholder="Country"
                                        v-model="listing.country"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group label="State" label-for="state">
                                    <b-form-input
                                        placeholder="State"
                                        v-model="listing.state"
                                        id="state"
                                        disabled
                                    />
                                </b-form-group>
                                <b-form-group
                                    label="District"
                                    label-for="district"
                                >
                                    <b-form-input
                                        placeholder="District"
                                        v-model="listing.district"
                                        id="district"
                                        disabled
                                    />
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </b-form>
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
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { can } from '@/auth/authentication.js'

export default {
    data() {
        return {
            legalDocuments: {},
            listingId: '',
            listing: {},
            client_documents: {},
            contractor_documents: {},
            legal_client_documents: {},
            legal_contractor_documents: {},
            finance_client_documents: {},
            finance_contractor_documents: {},

            statuses_color,

            can,

            perfectScrollbarSettings: {
                maxScrollbarLength: 60,
                height: 10
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
        VuePerfectScrollbar
    },
    methods: {
        ...mapActions({ loadLegalDocument: "contract/loadLegalDocument", uploadClientDoc: 'contract/uploadClientDoc',  uploadContractorDoc: 'contract/uploadContractorDoc' }),

        // upload contractor legal or payment documents
        uploadClientDocTrigger() {
            let clientData = new FormData();
            clientData.append( "listing_id", this.listingId );
            clientData.append( "legal_document_date", this.client_documents.legal_document_date );
            clientData.append( "user_type", "client" );
            clientData.append( "document_type", this.client_documents.document_type  );
            clientData.append( "notes", this.client_documents.notes );
            clientData.append( "percentage", this.client_documents.percentage );

            (this.client_documents.legal_documents) ? this.client_documents.legal_documents.forEach((legal_document) => {
                clientData.append("legal_document[]", legal_document);
            }): '';

            this.uploadClientDoc(clientData)
                .then((response) => {
                    if (response.success) {
                        console.log(response.data);
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
                        this.$router.push({ name: 'contracts.add', params: {listingId: this.listingId} })
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
        // upload contractor legal or payment documents
        uploadContractorDocTrigger() {
            let contractorData = new FormData();
            contractorData.append( "listing_id", this.listingId );
            contractorData.append( "legal_document_date", this.contractor_documents.legal_document_date );
            contractorData.append( "user_type", "contractor" );
            contractorData.append( "document_type", this.contractor_documents.document_type  );
            contractorData.append( "notes", this.contractor_documents.notes );
            contractorData.append( "percentage", this.contractor_documents.percentage );
            this.contractor_documents.legal_documents.forEach((legal_document) => {
                contractorData.append("legal_document[]", legal_document);
            });


            this.uploadContractorDoc(contractorData)
                .then((response) => {
                    if (response.success) {
                        console.log(response.data);
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
                        this.$router.push({ name: 'contracts.add', params: {listingId: this.listingId}  })
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
        ...mapGetters({ isLoading: "contract/getIsLoading", isDataLoading: "contract/getIsDataLoading" }),
    },
    created() {
        this.listingId = this.$route.params.listingId;

        this.loadLegalDocument({ listing_id: this.listingId })
            .then((response) => {
                if (response.success) {
                    this.legalDocuments = response.data[0];
                    console.log(this.legalDocuments);
                    this.listing = this.legalDocuments.listing;
                    this.finance_client_documents = this.legalDocuments.finance_client_documents;
                    this.finance_contractor_documents = this.legalDocuments.finance_contractor_documents;
                    this.legal_client_documents = this.legalDocuments.legal_client_documents;
                    this.legal_contractor_documents = this.legalDocuments.legal_contractor_documents;
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

<style>
</style>
