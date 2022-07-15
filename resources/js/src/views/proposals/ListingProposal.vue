<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="8" sm="12">
                <b-card-text> <h1>Proposals on {{ ListingTitle }}</h1> </b-card-text>
                <span class="text-small d-block"
                    >Location: {{ ListingAddress }}
                </span>
                <b-badge :variant="statuses_color[1][listing.status]" v-if="listing.status">
                    {{ statuses_color[0][listing.status] }}
                </b-badge>
            </b-col>
            <b-col md="4" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'proposals' }"
                    >
                        Back to Proposals
                    </b-button>
                </div>
            </b-col>
        </b-row>

        <!-- Date and amount Form -->
        <b-card>
            <b-overlay :show="isDataLoading"  spinner-variant="primary">
                <b-row>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Client Target Date
                        </h4>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Date"
                                label-for="target-date"
                                label-cols-md="3"
                            >
                                <b-form-input
                                    id="target-date"
                                    placeholder="Target Date"
                                    :value="listing.target_completion_datefrom + ' - ' + listing.target_completion_dateto"
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                    </b-col>
                    <b-col md="6">
                        <h4 class="mb-2 text-primary">
                            <feather-icon
                                icon="ChevronsUpIcon"
                                size="18"
                                class="mr-50"
                            />
                            Client Target Budget
                        </h4>
                        <b-col cols="12">
                            <b-form-group
                                label="Target Budget"
                                label-for="target-budget"
                                label-cols-md="3"
                            >
                                <b-form-input
                                    id="target-budget"
                                    placeholder="Target Budget"
                                    :value="listing.min_budget + ' - ' + listing.max_budget"
                                    disabled
                                />
                            </b-form-group>
                        </b-col>
                    </b-col>
                </b-row>
            </b-overlay>
        </b-card>
        <!-- Table -->
        <b-card title="Latest Proposals" no-body>
            <b-overlay :show="isDataLoading"  spinner-variant="primary">
                <b-card-body>
                    <b-row>
                        <b-col>
                            <!-- filter -->
                            <b-form-group
                                label="Search"
                                label-cols-sm="3"
                                label-align-sm="left"
                                label-size="md"
                                label-for="filterInput"
                                class="mb-0"
                            >
                                <b-input-group size="md">
                                    <b-form-input
                                        id="filterInput"
                                        v-model="filter"
                                        type="search"
                                        placeholder="Search Proposals"
                                    />
                                    <b-input-group-append>
                                        <b-button
                                            :disabled="!filter"
                                            @click="filter = ''"
                                        >
                                            Clear
                                        </b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col class="text-center">
                            <!-- Dates Filter -->
                            <b-button
                                v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                variant="flat-primary"
                            >
                                <feather-icon
                                    icon="CalendarIcon"
                                    class="mr-50"
                                />
                                <span class="align-middle">Last 3 Months</span>
                            </b-button>
                        </b-col>
                        <b-col>
                            <div class="form-row">
                                <div class="col p-0">
                                    <b-form-datepicker
                                        placeholder="From Date"
                                        id="filter_from_Date"
                                        class="mb-1 p-0 block"
                                        name="filter_from_Date"
                                    />
                                </div>
                                <div class="col p-0">
                                    <b-form-datepicker
                                        placeholder="To Date"
                                        id="filter_to_Date"
                                        name="filter_to_Date"
                                        class="mb-1 p-0"
                                    />
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                </b-card-body>

                <b-table
                    striped
                    responsive
                    class="position-relative"
                    :per-page="perPage"
                    :current-page="currentPage"
                    :items="items"
                    :fields="fields"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    :filter="filter"
                    :filter-included-fields="filterOn"
                    @filtered="onFiltered"
                >

                    <template #cell(title)="data">
                        <b-media vertical-align="center">
                            <template #aside>
                                <b-avatar
                                size="40"
                                :src="data.item.contractor.avatar"
                                variant="light-primary"
                                />
                            </template>
                            <span class="font-weight-bold d-block text-nowrap mt-1">
                                {{ data.item.contractor.user_name }}
                            </span>
                            </b-media>
                    </template>
                    <template #cell(status)="data">
                        <b-badge :variant="statuses_color[1][data.value]">
                            {{ statuses_color[0][data.value] }}
                        </b-badge>
                    </template>
                    <template #cell(target_budget)="data">
                        <div class="border border-primary p-1">
                         {{ data.item.min_budget }} -
                         {{ data.item.max_budget }}
                        </div>
                    </template>
                    <!-- <template #cell(location)="data">
                        {{
                            data.item.listing.addaddress_line1
                                ? data.item.listing.addaddress_line1
                                : ""
                        }}
                        {{ data.item.listing.district ? data.item.listing.district : "" }}
                        {{ data.item.listing.state ? data.item.listing.state : "" }}
                        {{ data.item.listing.country ? data.item.listing.country : "" }}
                    </template> -->
                    <template #cell(target_date)="data">
                        <div class="border border-primary p-1">

                        {{ data.item.target_startdate }} -
                         {{ data.item.target_enddate }}
                        </div>
                    </template>
                    <template #cell(proposal_date)="data">
                         {{ new Date(data.item.listing.created_at).toDateString() }}
                    </template>
                    <template #cell(actions)="data">

                        <b-button
                         v-if=" ( data.item.status === 'approved' && can('create', 'all-proposal') || data.item.status === 'approved' && can('create', 'precontract') ) "
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="success"
                            size="sm"
                            @click="assignContractTrigger(data.item.listing.id, data.item.contractor.id)"
                        >
                            Assign
                        </b-button>

                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            size="sm"
                            :to="{
                                name: 'proposals.view',
                                params: { proposalId: data.item.id },
                            }"
                        >
                            See Details
                        </b-button>

                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="warning"
                            size="sm"
                            :to="{
                                name: 'proposals.edit',
                                params: { proposalId: data.item.id },
                            }"
                        >
                            <feather-icon icon="EditIcon" size="15" />
                        </b-button>
                        <!-- delete -->
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="danger"
                            size="sm"
                            @click="deleteTrigger( data.item.id, data.index )"
                        >
                            <feather-icon icon="XIcon" size="15" />
                        </b-button>

                    </template>
                </b-table>

                <b-card-body
                    class="d-flex justify-content-between flex-wrap pt-0"
                >
                    <!-- page length -->
                    <b-form-group
                        label="Per Page"
                        label-cols="6"
                        label-align="left"
                        label-size="sm"
                        label-for="sortBySelect"
                        class="text-nowrap mb-md-0 mr-1"
                    >
                        <b-form-select
                            id="perPageSelect"
                            v-model="perPage"
                            size="sm"
                            inline
                            :options="pageOptions"
                        />
                    </b-form-group>

                    <!-- pagination -->
                    <div>
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            first-number
                            last-number
                            prev-class="prev-item"
                            next-class="next-item"
                            class="mb-0"
                        >
                            <template #prev-text>
                                <feather-icon
                                    icon="ChevronLeftIcon"
                                    size="18"
                                />
                            </template>
                            <template #next-text>
                                <feather-icon
                                    icon="ChevronRightIcon"
                                    size="18"
                                />
                            </template>
                        </b-pagination>
                    </div>
                </b-card-body>
            </b-overlay>
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
    BTable,
    BAvatar,
    BBadge,
    BFormGroup,
    BFormSelect,
    BPagination,
    BInputGroup,
    BFormInput,
    BInputGroupAppend,
    BCardBody,
    BOverlay,
    BFormDatepicker,
    BMedia,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { mapGetters, mapActions } from "vuex";
import { statuses_color } from "@/fieldsdata/index.js";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { can } from '@/auth/authentication.js'

export default {
    components: {
        BRow,
        BCol,
        BCard,
        BButton,
        BCardText,
        BLink,
        BTable,
        BAvatar,
        BBadge,
        BFormGroup,
        BFormSelect,
        BPagination,
        BInputGroup,
        BFormInput,
        BInputGroupAppend,
        BCardBody,
        BOverlay,
        BFormDatepicker,
        BMedia,
    },
    data() {
        return {
            perPage: 25,
            pageOptions: [10, 25, 50],
            totalRows: 1,
            currentPage: 1,
            sortBy: "",
            sortDesc: false,
            sortDirection: "asc",
            filter: null,
            filterOn: [],
            fields: [
                { key: "id", label: "Id" },
                { key: "title", label: "Contractor Name" },
                { key: "status", label: "Contract Status", sortable: true },
                { key: "target_budget", label: "Target Budget", sortable: true },
                // { key: "location", label: "Location", sortable: true },
                { key: "target_date", label: "Target Date", sortable: true, },
                { key: "proposal_date", label: "Proposal Date", sortable: true },
                "actions",
            ],
            items: [],
            listing: {},
            ListingTitle: '',
            ListingAddress: '',
            listingId: '',
            statuses_color,

            can,
        };
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter((f) => f.sortable)
                .map((f) => ({ text: f.label, value: f.key }));
        },
        ...mapGetters({ isLoading: "proposal/getIsLoading", isDataLoading: "proposal/getIsDataLoading" }),


    },
    mounted() {
        this.listingId = this.$route.params.listingId;
        // getting proposals on listing
        this.loadListingProposals({ listing_id: this.listingId})
            .then((response) => {
                console.log(response);
                if (response.success) {
                    this.items = response.data;
                    this.listing = this.items[0].listing
                    this.ListingTitle = this.items[0].listing.title
                    this.ListingAddress = this.items[0].listing.address_line1

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

        // Set the initial number of items
        this.totalRows = this.items.length;
    },
    methods: {
        ...mapActions({ loadListingProposals: "proposal/loadListingProposals", assignContract: 'proposal/assignContract', deleteListingsProposal: "proposal/deleteListingsProposal" }),

        assignContractTrigger(listingId, contractortId) {
            console.log(listingId, contractortId);
            let assignData = new FormData();
            assignData.append( "listing_id", listingId );
            assignData.append( "contractor_id",  contractortId);

            this.assignContract(assignData)
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
                        this.$router.push({ name: 'proposals' })
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

        deleteTrigger( id, index ) {
            if( confirm("Are you sure, you want to withdraw your proposal?") ) {

                this.deleteListingsProposal({ proposal_id: id })
                    .then((response) => {
                        if(response.success) {
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: response.message,
                                    icon: "EditIcon",
                                    variant: "success",
                                },
                            });
                            this.items.splice(index, 1)
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
            }

        },

        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },

    },
    directives: {
        Ripple,
    },
};
</script>

<style></style>


