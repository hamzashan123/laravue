<template>
    <div>
        <!-- Header -->
        <b-row class="mb-3">
            <b-col md="8" sm="12">
                <b-card-text> <h1>Project Contracts</h1> </b-card-text>
            </b-col>
            <b-col md="4" sm="12">
                <div>
                    <b-form-group
                        label="Filter by Contract Status"
                        label-size="md"
                        label-cols-sm="0"
                        label-for="sortByStatus"
                        class="mr-1 mb-md-0"
                    >
                        <b-input-group size="md">
                            <b-form-select
                                id="sortByStatus"
                                v-model="sortBy"
                                :options="statuses_color[0]"
                            >
                                <template #first>
                                    <option value="">Select Status</option>
                                </template>
                            </b-form-select>
                        </b-input-group>
                    </b-form-group>
                </div>
            </b-col>
        </b-row>

        <!-- Table -->
        <b-card title="Latest Contracts" no-body>
            <b-overlay :show="isDataLoading" spinner-variant="primary">
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
                    show-empty
                >

                    <template #cell(contractor)="data">
                        {{ data.item.contractor ? data.item.contractor.first_name +" " : '' }}
                        {{ data.item.contractor ? data.item.contractor.last_name : '' }}
                    </template>
                    <template #cell(title)="data">
                        <b-media vertical-align="center">
                            <template #aside>
                                <b-avatar
                                    size="40"
                                    v-for="(
                                        image, idx
                                    ) in data.item.listing.images.slice(0, 1)"
                                    :key="idx"
                                    :src="image"
                                    variant="light-primary"
                                />
                            </template>
                            <span
                                class="font-weight-bold d-block text-nowrap mt-1"
                            >
                                {{ data.item.listing.title }}
                            </span>
                        </b-media>
                    </template>
                    <template #cell(status)="data">
                        <b-badge :variant="statuses_color[1][data.value]">
                            {{ statuses_color[0][data.value] }}
                        </b-badge>
                    </template>
                    <template #cell(location)="data">
                        {{
                            data.item.listing.addaddress_line1
                                ? data.item.listing.addaddress_line1 + ", "
                                : ""
                        }}
                        {{
                            data.item.listing.district
                                ? data.item.listing.district + ", "
                                : ""
                        }}
                        {{
                            data.item.listing.state
                                ? data.item.listing.state + ", "
                                : ""
                        }}
                        {{
                            data.item.listing.country
                                ? data.item.listing.country
                                : ""
                        }}
                    </template>
                    <template #cell(listing_date)="data">
                        {{
                            new Date(
                                data.item.listing.created_at
                            ).toDateString()
                        }}
                    </template>
                    <template #cell(target_start_date)="data">
                        {{ data.item.listing.target_completion_datefrom }}
                    </template>
                    <template #cell(actions)="data">
                        <!-- <b-button
                            v-if="can('create', 'all-contract')"
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mb-1"
                            :to="{
                                name: 'contracts.add',
                                params: { listingId: data.item.listing.id },
                            }"
                        >
                            Add Docs
                        </b-button> -->
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            size="sm"
                            :to="{
                                name: 'contracts.view',
                                params: { listingId: data.item.listing.id },
                            }"
                        >
                            See Details
                        </b-button>

                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="warning"
                            size="sm"
                            to=""
                        >
                            <feather-icon icon="EditIcon" size="15" />
                        </b-button>
                        <!-- delete -->
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="danger"
                            size="sm"
                            to=""
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
import { can } from "@/auth/authentication.js";

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
                { key: "title", label: "Listing" },
                { key: "contractor", label: "Contractor" },
                { key: "status", label: "Contract Status", sortable: true },
                { key: "location", label: "Location", sortable: true },
                { key: "listing_date", label: "Listing Date", sortable: true },
                {
                    key: "target_start_date",
                    label: "Target Start Date",
                    sortable: true,
                },
                "actions",
            ],
            items: [],
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
        ...mapGetters({
            isLoading: "contract/getIsLoading",
            isDataLoading: "contract/getIsDataLoading",
        }),
    },
    mounted() {
        // getting contracts on listing
        this.loadContracts()
            .then((response) => {
                console.log(response);
                if (response.success) {
                    this.items = response.data;
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
        ...mapActions({ loadContracts: "contract/loadContracts" }),

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
