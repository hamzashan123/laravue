<template>
    <div>
        <!-- Header -->
        <!-- <b-card> -->
        <b-row class="mb-4">
            <b-col md="6" sm="12">
                <b-card-text> <h1>Project Listings</h1> </b-card-text>
            </b-col>
            <b-col md="6" sm="12">
                <div class="text-right">
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'listings.add' }"
                    >
                        Create New Listing
                    </b-button>
                </div>
            </b-col>
        </b-row>
        <!-- </b-card> -->
        <!-- Table -->
        <b-card title="Latest Listings" no-body>
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
                                placeholder="Search Project Listing"
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

                    <!-- sorting  -->
                    <b-form-group
                        label="Sort"
                        label-size="md"
                        label-align-sm="left"
                        label-cols-sm="2"
                        label-for="sortBySelect"
                        class="mr-1 mb-md-0"
                    >
                        <b-input-group size="md">
                            <b-form-select
                                id="sortBySelect"
                                v-model="sortBy"
                                :options="sortOptions"
                            >
                                <template #first>
                                    <option value="">none</option>
                                </template>
                            </b-form-select>
                            <b-form-select
                                v-model="sortDesc"
                                size="md"
                                :disabled="!sortBy"
                            >
                                <option :value="false">Asc</option>
                                <option :value="true">Desc</option>
                            </b-form-select>
                        </b-input-group>
                    </b-form-group>
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
                <template #cell(listing_image)="data">
                    <b-avatar :src="data.value" class="mx-1" />
                </template>
                <template #cell(listing_name)="data">
                    <span class="text-nowrap">{{ data.value }}</span>
                </template>
                <template #cell(contract_status)="data">
                    <b-badge pill :variant="contract_status[1][data.value]">
                        {{ contract_status[0][data.value] }}
                    </b-badge>
                </template>
                <template #cell(actions)>
                    <b-button
                        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                        variant="primary"
                        :to="{ name: 'listings.view' }"
                    >
                        See Details
                    </b-button>
                </template>
            </b-table>

            <b-card-body class="d-flex justify-content-between flex-wrap pt-0">
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
                            <feather-icon icon="ChevronLeftIcon" size="18" />
                        </template>
                        <template #next-text>
                            <feather-icon icon="ChevronRightIcon" size="18" />
                        </template>
                    </b-pagination>
                </div>
            </b-card-body>
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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

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
    },
    data() {
        return {
            perPage: 5,
            pageOptions: [3, 5, 10],
            totalRows: 1,
            currentPage: 1,
            sortBy: "",
            sortDesc: false,
            sortDirection: "asc",
            filter: null,
            filterOn: [],
            //   infoModal: {
            //     id: "info-modal",
            //     title: "",
            //     content: "",
            //   },
            fields: [
                {
                    key: "id",
                    label: "Id",
                },
                {
                    key: "listing_image",
                    label: "",
                },
                {
                    key: "listing_name",
                    label: "Listing Name",
                },
                {
                    key: "contract_status",
                    label: "Contract Status",
                    sortable: true,
                },
                { key: "location", label: "Location", sortable: true },
                "listing_date",
                {
                    key: "no_of_proposals",
                    label: "# of proposals",
                    sortable: true,
                },
                "actions",
            ],
            /* eslint-disable global-require */
            items: [
                {
                    id: 1,
                    listing_image: require("@/assets/images/avatars/10-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 2,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 2,
                    listing_image: require("@/assets/images/avatars/1-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 1,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 3,
                    listing_image: require("@/assets/images/avatars/9-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 5,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 4,
                    listing_image: require("@/assets/images/avatars/3-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 3,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 5,
                    listing_image: require("@/assets/images/avatars/4-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 2,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 6,
                    listing_image: require("@/assets/images/avatars/5-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 1,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 7,
                    listing_image: require("@/assets/images/avatars/7-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 3,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 8,
                    listing_image: require("@/assets/images/avatars/9-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 3,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 9,
                    listing_image: require("@/assets/images/avatars/2-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 3,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
                {
                    id: 10,
                    listing_image: require("@/assets/images/avatars/6-small.png"),
                    listing_name: "Korrie O'Crevy",
                    contract_status: 2,
                    location: "Nuclear Power Engineer",
                    listing_date: "09/23/2016",
                    no_of_proposals: "61",
                },
            ],
            /* eslint-disable global-require */
            contract_status: [
                {
                    1: "Contract Started!",
                    2: "Waiting Assigned",
                    3: "Draft Not yet publised",
                    4: "Contract Assigned",
                    5: "Completed",
                },
                {
                    1: "light-primary",
                    2: "light-warning",
                    3: "light-danger",
                    4: "light-info",
                    5: "light-success",
                },
            ],
        };
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter((f) => f.sortable)
                .map((f) => ({ text: f.label, value: f.key }));
        },
    },
    mounted() {
        // Set the initial number of items
        this.totalRows = this.items.length;
    },
    methods: {
        // info(item, index, button) {
        //   this.infoModal.title = `Row index: ${index}`;
        //   this.infoModal.content = JSON.stringify(item, null, 2);
        //   this.$root.$emit("bv::show::modal", this.infoModal.id, button);
        // },
        // resetInfoModal() {
        //   this.infoModal.title = "";
        //   this.infoModal.content = "";
        // },
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
