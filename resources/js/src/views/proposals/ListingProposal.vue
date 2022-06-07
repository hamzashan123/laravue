<template>
    <div>
        <!-- Header -->
        <b-row class="mb-4">
            <b-col md="8" sm="12">
                <b-card-text> <h1>Proposals on {{ ListingTitle }}</h1> </b-card-text>
                <span class="text-small"
                    >Location: {{ ListingAddress }}
                </span>
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
            <b-overlay :show="isDataLoading" rounded="sm">
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
                                    value=" 2022-03-03 - 2022-03-03 "
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
                            Contractor Target Budget
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
                                    value="50000 - 1500000"
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
            <b-overlay :show="isDataLoading" rounded="sm">
                <b-card-body>
                    <div class="d-flex justify-content-between flex-wrap">
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
                        <!-- Dates Filter -->
                        <b-button
                            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                            variant="flat-primary"
                        >
                            <feather-icon icon="CalendarIcon" class="mr-50" />
                            <span class="align-middle">Last 3 Months</span>
                        </b-button>

                        <b-button
                            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                            variant="flat-primary"
                        >
                            <feather-icon icon="CalendarIcon" class="mr-50" />
                            <span class="align-middle">Last 6 Months</span>
                        </b-button>

                        <b-button
                            v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                            variant="flat-primary"
                        >
                            <feather-icon icon="CalendarIcon" class="mr-50" />
                            <span class="align-middle">Last 12 Months</span>
                        </b-button>

                        <div class="form-row">
                            <div class="col p-0">
                                <b-form-datepicker
                                    placeholder="From Date"
                                    id="target_completion_datefrom"
                                    class="mb-1 p-0"
                                    name="target_completion_datefrom"
                                />
                            </div>
                            <div class="col p-0">
                                <b-form-datepicker
                                    placeholder="To Date"
                                    id="target_completion_dateto"
                                    name="target_completion_dateto"
                                    class="mb-1 p-0"
                                />
                            </div>
                        </div>
                    </div>
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
                                size="32"
                                :src="data.item.contractor.avatar"
                                :text="data.item.contractor.first_name"
                                variant="parimary"
                                />
                            </template>
                            <span class="font-weight-bold d-block text-nowrap">
                                {{ data.item.contractor.first_name }}
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
                    <template #cell(location)="data">
                        {{
                            data.item.listing.addaddress_line1
                                ? data.item.listing.addaddress_line1
                                : ""
                        }}
                        {{ data.item.listing.district ? data.item.listing.district : "" }}
                        {{ data.item.listing.state ? data.item.listing.state : "" }}
                        {{ data.item.listing.country ? data.item.listing.country : "" }}
                    </template>
                    <template #cell(target_date)="data">
                        <div class="border border-primary p-1">

                        {{ data.item.target_startdate }} -
                         {{ data.item.target_enddate }}
                        </div>
                    </template>
                    <template #cell(proposal_date)="data">
                         {{ data.item.listing.created_at }}
                    </template>
                    <template #cell(actions)="data">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            :class="data.value"
                            :to="{
                                name: 'proposals.view',
                                params: { proposalId: data.item.id },
                            }"
                        >
                            See Details
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
                { key: "location", label: "Location", sortable: true },
                { key: "target_date", label: "Target Date", sortable: true, },
                { key: "proposal_date", label: "Proposal Date", sortable: true },
                "actions",
            ],
            items: [],
            ListingTitle: '',
            ListingAddress: '',
            listingId: '',
            statuses_color,
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
        ...mapActions({ loadListingProposals: "proposal/loadListingProposals" }),

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


