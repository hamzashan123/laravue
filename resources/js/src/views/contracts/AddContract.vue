<template>
    <div>
        <!-- Header -->
        <!-- <b-card> -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text>
                    <h1>Add documents on {{ listing.title }}</h1>
                    <b-badge
                        :variant="statuses_color[1][listing.status]"
                        v-if="listing.status"
                    >
                        {{ statuses_color[0][listing.status] }}
                    </b-badge>
                </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{
                            name: 'contracts.view',
                            params: { contractId: 1 },
                        }"
                    >
                        See Details
                    </b-button>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="secondary"
                        :to="{ name: 'contracts' }"
                    >
                        Back
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <!-- </b-card> -->

        <!-- LEgal and Payment Status -->
        <b-card v-if="!noData">
            <b-row>
                <b-col md="3">
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
                            <div class="d-flex align-items-center mb-2">
                                <h5 class=" mr-2">Status</h5>
                                <div class="font-large-1">{{ legal_client_total_percentage }}%</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <h5 class="mb-2">Documents</h5>
                            <div
                                v-for="(
                                    documentsArray, i
                                ) in legal_client_documents"
                                :key="i"
                            >
                                <div
                                    class="d-flex align-items-center"
                                    v-for="(
                                        doc, idx
                                    ) in documentsArray.documents"
                                    :key="doc.id"
                                >
                                    <b-avatar
                                        variant="light-dark"
                                        square
                                        :text="docExtension(doc.legal_document_name)"
                                        size="md"
                                    />
                                    <!-- link button -->
                                    <b-button
                                        v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                        variant="outline-dark"
                                        size="sm"
                                        :href="doc.legal_document_path"
                                        target="_blank"
                                    >
                                        {{ doc.legal_document_name }}
                                    </b-button>

                                    <!-- remove button -->
                                    <b-button
                                        @click="removeSelectedFile(idx, doc)"
                                        variant="gradient-danger"
                                        size="sm"
                                        class="btn-icon rounded-circle ml-3px"
                                        >
                                        <feather-icon icon="XIcon" size="10" />
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col md="3">
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
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mr-2">Status</h5>
                                <div class="font-large-1">{{ legal_contractor_total_percentage }}%</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <h5 class="mb-2">Documents</h5>
                            <div
                                v-for="(
                                    documentsArray, i
                                ) in legal_contractor_documents"
                                :key="i"
                            >
                                <div
                                    class="d-flex align-items-center"
                                    v-for="(
                                        doc, idx
                                    ) in documentsArray.documents"
                                    :key="doc.id"
                                >
                                    <b-avatar
                                        variant="light-dark"
                                        square
                                        :text="docExtension(doc.legal_document_name)"
                                        size="md"
                                    />
                                    <b-button
                                        v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                        variant="outline-dark"
                                        size="sm"
                                        :href="doc.legal_document_path"
                                        target="_blank"
                                    >
                                        {{ doc.legal_document_name }}
                                    </b-button>
                                    <!-- remove button -->
                                    <b-button
                                        @click="removeSelectedFile(idx, doc)"
                                        variant="gradient-danger"
                                        size="sm"
                                        class="btn-icon rounded-circle ml-3px"
                                        >
                                        <feather-icon icon="XIcon" size="10" />
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col md="3">
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
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mr-2">Status</h5>
                                <div class="font-large-1">{{ finance_client_total_percentage }}%</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <h5 class="mb-2">Documents</h5>
                            <div
                                v-for="(
                                    documentsArray, i
                                ) in finance_client_documents"
                                :key="i"
                            >
                                <div
                                    class="d-flex align-items-center"
                                    v-for="(
                                        doc, idx
                                    ) in documentsArray.documents"
                                    :key="doc.id"
                                >
                                    <b-avatar
                                        variant="light-dark"
                                        square
                                        :text="docExtension(doc.legal_document_name)"
                                        size="md"
                                    />
                                    <b-button
                                        v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                        variant="outline-dark"
                                        size="sm"
                                        :href="doc.legal_document_path"
                                        target="_blank"
                                    >
                                        {{ doc.legal_document_name }}
                                    </b-button>
                                    <!-- remove button -->
                                    <b-button
                                        @click="removeSelectedFile(idx, doc)"
                                        variant="gradient-danger"
                                        size="sm"
                                        class="btn-icon rounded-circle ml-3px"
                                        >
                                        <feather-icon icon="XIcon" size="10" />
                                    </b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </b-col>
                <b-col md="3">
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
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="mr-2">Status</h5>
                                <div class="font-large-1">{{ finance_contractor_total_percentage }}%</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <h5 class="mb-2">Documents</h5>
                            <div
                                v-for="(
                                    documentsArray, i
                                ) in finance_contractor_documents"
                                :key="i"
                            >
                                <div
                                    class="d-flex align-items-center"
                                    v-for="(
                                        doc, idx
                                    ) in documentsArray.documents"
                                    :key="doc.id"
                                >
                                    <b-avatar
                                        variant="light-dark"
                                        square
                                        :text="docExtension(doc.legal_document_name)"
                                        size="md"
                                    />
                                    <b-button
                                        v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                        variant="outline-dark"
                                        size="sm"
                                        target="_blank"
                                        :href="doc.legal_document_path"
                                    >
                                        {{ doc.legal_document_name }}
                                    </b-button>
                                    <!-- remove button -->
                                    <b-button
                                        @click="removeSelectedFile(idx, doc)"
                                        variant="gradient-danger"
                                        size="sm"
                                        class="btn-icon rounded-circle ml-3px"
                                        >
                                        <feather-icon icon="XIcon" size="10" />
                                    </b-button>
                                </div>
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
                            <!-- client -->
                            <b-tab active v-if="userRole == 1 || userRole == 3">
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
                                            v-model="
                                                client_documents.document_type
                                            "
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
                                                    v-model="
                                                        client_documents.notes
                                                    "
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
                                                    v-model="
                                                        client_documents.percentage
                                                    "
                                                    id="Percetange"
                                                    placeholder="%"
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
                                                    v-model="
                                                        client_documents.legal_documents
                                                    "
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
                                                    v-model="
                                                        client_documents.legal_document_date
                                                    "
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
                                            @click="uploadClientDocTrigger"
                                        >
                                            Save Details
                                            <b-spinner small v-if="isLoading" />
                                        </b-button>
                                    </b-col>
                                </div>
                            </b-tab>
                            <!-- Contractor -->
                            <b-tab  v-if="userRole == 2 || userRole == 3">
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
                                            v-model="
                                                contractor_documents.document_type
                                            "
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
                                                    v-model="
                                                        contractor_documents.notes
                                                    "
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
                                                    v-model="
                                                        contractor_documents.percentage
                                                    "
                                                    id="Percetange"
                                                    placeholder="%"
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
                                                    v-model="
                                                        contractor_documents.legal_documents
                                                    "
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
                                                    v-model="
                                                        contractor_documents.legal_document_date
                                                    "
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
                            <!-- comments -->
                            <b-tab @click="refreshComments">
                                <template #title>
                                    <feather-icon icon="MessageCircleIcon" />
                                    <span>Comment</span>
                                </template>
                                <div class="mb-2">
                                    <b-form-group
                                        label="Add your Comment"
                                        label-for="comment"
                                        class="p-1"
                                    >
                                        <b-form-textarea
                                            v-model="comment"
                                            id="comment"
                                            placeholder="Comment"
                                            rows="3"
                                        />
                                    </b-form-group>
                                    <b-col class="text-right p-1">
                                        <b-button
                                            v-ripple.400="
                                                'rgba(255, 255, 255, 0.15)'
                                            "
                                            type="submit"
                                            variant="primary"
                                            @click="addCommentTrigger"
                                        >
                                            Add Comment
                                            <b-spinner small v-if="isLoading" />
                                        </b-button>
                                    </b-col>
                                    <vue-perfect-scrollbar
                                        :settings="perfectScrollbarSettings"
                                        class="user-chats scroll-area p-1 mb-4"
                                    >
                                        <div
                                            class="comments position-relative"
                                            style="height: 60vh"
                                        >
                                            <div
                                                class="d-flex align-item-center mb-1 mt-1 pb-1"
                                                v-for="comment in comments"
                                                :key="comment.id"
                                            >
                                                <b-avatar
                                                    size="32"
                                                    variant="light-primary"
                                                    class="mr-1"
                                                    src=""
                                                />
                                                <div
                                                    :class="
                                                        comment.user_role ==
                                                        'Contractor'
                                                            ? 'border-primary '
                                                            : '' ||
                                                              comment.user_role ==
                                                                  'EBStaff'
                                                            ? 'border-warning '
                                                            : '' ||
                                                              comment.user_role ==
                                                                  'Client'
                                                            ? 'border-info'
                                                            : ''
                                                    "
                                                    class="chat-info col shadow p-1 bg-white rounded border-bottom-0 border-right-0 border-top-0"
                                                >
                                                    <div
                                                        class="d-flex align-item-center justify-content-between"
                                                    >
                                                        <h5
                                                            class="mb-0 p-0 mr-2 d-inline"
                                                        >
                                                            {{
                                                                comment.user_name
                                                            }}
                                                        </h5>
                                                        <small class="ml-auto">
                                                            {{
                                                                new Date(
                                                                    comment.created_at
                                                                ).toDateString()
                                                            }}
                                                        </small>

                                                        <b-badge
                                                            class="ml-3px"
                                                            :variant="
                                                                comment.user_role ==
                                                                'Contractor'
                                                                    ? 'primary '
                                                                    : '' ||
                                                                      comment.user_role ==
                                                                          'EBStaff'
                                                                    ? 'warning '
                                                                    : '' ||
                                                                      comment.user_role ==
                                                                          'Client'
                                                                    ? 'info'
                                                                    : ''
                                                            "
                                                        >
                                                            {{
                                                                comment.user_role
                                                            }}
                                                        </b-badge>
                                                    </div>

                                                    <p
                                                        class="card-text h4 mt-1 font-italic"
                                                    >
                                                        {{ comment.message }}
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
                        <show-title-description heading="Listing Details" :listing="listing" />
                        <b-row>
                            <b-col lg="6" class="mb-2">
                                <show-map lat=20.5937 lng=78.9629 />
                            </b-col>
                            <b-col lg="6">
                                <show-address :listing="listing"/>
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
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import { mapActions, mapGetters } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { can } from "@/auth/authentication.js";
import ShowMap from "@/components/ShowMap.vue";
import ShowTitleDescription from '@/components/ShowTitleDescription.vue'
import ShowAddress from '@/components/ShowAddress.vue'

export default {
    data() {
        return {
            noData: false,
            legalDocuments: {},
            listingId: "",
            listing: {},
            client_documents: {},
            contractor_documents: {},
            legal_client_documents: {},
            legal_contractor_documents: {},
            finance_client_documents: {},
            finance_contractor_documents: {},
            legal_client_total_percentage: 0,
            legal_contractor_total_percentage: 0,
            finance_client_total_percentage: 0,
            finance_contractor_total_percentage: 0,

            comment: "",
            userRole: '',

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
        ShowMap,
        ShowTitleDescription,
        ShowAddress,
    },
    methods: {
        ...mapActions({
            loadLegalDocument: "contract/loadLegalDocument",
            uploadClientDoc: "contract/uploadClientDoc",
            uploadContractorDoc: "contract/uploadContractorDoc",
            loadComments: "contract/loadComments",
            addComment: "contract/addComment",
            archiveDocuments: 'contract/archiveDocuments'
        }),

        // remove files
        removeSelectedFile(index, receivedDoc) {
            this.archiveDocumentsTrigger(receivedDoc)

            this.loadLegalDocumentTrigger()

        },

        // upload contractor legal or payment documents
        uploadClientDocTrigger() {
            let clientData = new FormData();
            clientData.append("listing_id", this.listingId);
            clientData.append(
                "legal_document_date",
                this.client_documents.legal_document_date
            );
            clientData.append("user_type", "client");
            clientData.append(
                "document_type",
                this.client_documents.document_type
            );
            clientData.append("notes", this.client_documents.notes);
            clientData.append("percentage", this.client_documents.percentage);

            this.client_documents.legal_documents
                ? this.client_documents.legal_documents.forEach(
                      (legal_document) => {
                          clientData.append("legal_document[]", legal_document);
                      }
                  )
                : "";

            this.uploadClientDoc(clientData)
                .then((response) => {
                    if (response.success) {

                        this.legalDocuments = response.user[0];

                        this.finance_client_documents =
                            this.legalDocuments.finance_client_documents;
                        this.finance_contractor_documents =
                            this.legalDocuments.finance_contractor_documents;
                        this.legal_client_documents =
                            this.legalDocuments.legal_client_documents;
                        this.legal_contractor_documents =
                            this.legalDocuments.legal_contractor_documents;
                        this.finance_client_total_percentage =
                            this.legalDocuments.finance_client_total_percentage;
                        this.legal_client_total_percentage =
                            this.legalDocuments.legal_client_total_percentage;

                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
                        this.noData = false;
                        // this.$router.push({
                        //     name: "contracts.add",
                        //     params: { listingId: this.listingId },
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
            contractorData.append("listing_id", this.listingId);
            contractorData.append(
                "legal_document_date",
                this.contractor_documents.legal_document_date
            );
            contractorData.append("user_type", "contractor");
            contractorData.append(
                "document_type",
                this.contractor_documents.document_type
            );
            contractorData.append("notes", this.contractor_documents.notes);
            contractorData.append(
                "percentage",
                this.contractor_documents.percentage
            );
            this.contractor_documents.legal_documents.forEach(
                (legal_document) => {
                    contractorData.append("legal_document[]", legal_document);
                }
            );

            this.uploadContractorDoc(contractorData)
                .then((response) => {
                    if (response.success) {

                        this.legalDocuments = response.user[0];

                        this.finance_client_documents =
                            this.legalDocuments.finance_client_documents;
                        this.finance_contractor_documents =
                            this.legalDocuments.finance_contractor_documents;
                        this.legal_client_documents =
                            this.legalDocuments.legal_client_documents;
                        this.legal_contractor_documents =
                            this.legalDocuments.legal_contractor_documents;

                        this.finance_contractor_total_percentage =
                            this.legalDocuments.finance_contractor_total_percentage;
                        this.legal_contractor_total_percentage =
                            this.legalDocuments.legal_contractor_total_percentage;

                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
                        this.noData = false;
                        // this.$router.push({
                        //     name: "contracts.add",
                        //     params: { listingId: this.listingId },
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

        // Add commments
        addCommentTrigger() {
            let commentData = new FormData();
            commentData.append("listing_id", this.listingId);
            commentData.append("message", this.comment);

            this.addComment(commentData)
                .then((response) => {
                    if (response.success) {
                        this.comment = "";
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
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

        archiveDocumentsTrigger(docObj) {
            let formData = new FormData();
            formData.append("document_id", docObj.listing_document_id);
            formData.append("image_url", docObj.legal_document_path);

            this.archiveDocuments(formData)
                .then((response) => {
                    if (response.success) {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: response.message,
                                icon: "EditIcon",
                                variant: "success",
                            },
                        });
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
                            title: "Error While Adding!",
                            icon: "EditIcon",
                            variant: "danger",
                        },
                    });
                });
        },

        docExtension(docName) {
            return docName.split('.').pop()

        },

        loadLegalDocumentTrigger() {
            this.loadLegalDocument({ listing_id: this.listingId })
            .then((response) => {
                if (response.success) {
                    if (response.data[0].length == 0) {
                        this.noData = true;
                    } else {
                        this.listing = response.data[0].listing;
                        // Docs Data
                        this.finance_client_documents =
                            response.data[0].finance_client_documents;
                        this.finance_contractor_documents =
                            response.data[0].finance_contractor_documents;
                        this.legal_client_documents =
                            response.data[0].legal_client_documents;
                        this.legal_contractor_documents =
                            response.data[0].legal_contractor_documents;

                        // Percentages
                        this.finance_client_total_percentage =
                            response.data[0].finance_client_total_percentage;
                        this.finance_contractor_total_percentage =
                            response.data[0].finance_contractor_total_percentage;
                        this.legal_client_total_percentage =
                            response.data[0].legal_client_total_percentage;
                        this.legal_contractor_total_percentage =
                            response.data[0].legal_contractor_total_percentage;
                    }
                } else {
                    console.log("else");

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

        refreshComments() {
            this.loadComments( { listing_id: this.listingId } );
        },
    },
    computed: {
        ...mapGetters({
            isLoading: "contract/getIsLoading",
            isDataLoading: "contract/getIsDataLoading",
            comments: "contract/getComments",
        }),


    },
    created() {

        this.userRole = JSON.parse(localStorage.getItem("userData")).user_role.id

        this.listingId = this.$route.params.listingId;

        this.loadLegalDocument({ listing_id: this.listingId })
            .then((response) => {
                if (response.success) {
                    if (response.data[0].length == 0) {
                        this.noData = true;
                    } else {
                        this.listing = response.data[0].listing;
                        // Docs Data
                        this.finance_client_documents =
                            response.data[0].finance_client_documents;
                        this.finance_contractor_documents =
                            response.data[0].finance_contractor_documents;
                        this.legal_client_documents =
                            response.data[0].legal_client_documents;
                        this.legal_contractor_documents =
                            response.data[0].legal_contractor_documents;

                        // Percentages
                        this.finance_client_total_percentage =
                            response.data[0].finance_client_total_percentage;
                        this.finance_contractor_total_percentage =
                            response.data[0].finance_contractor_total_percentage;
                        this.legal_client_total_percentage =
                            response.data[0].legal_client_total_percentage;
                        this.legal_contractor_total_percentage =
                            response.data[0].legal_contractor_total_percentage;
                    }
                } else {
                    console.log("else");

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

        this.loadComments({ listing_id: this.listingId });
    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>
