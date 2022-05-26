<template>
  <div>
    <!-- Header -->
    <b-row class="mb-4">
      <b-col md="8" sm="12">
        <b-card-text> <h1>Proposals on Bhadurgarh</h1> </b-card-text>
        <span class="text-small">Location: West bahdruarh, Virginia, US </span>
      </b-col>
      <b-col md="4" sm="12">
        <div class="text-right">
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            :to="{ name: 'listings.detail' }"
          >
            Back to Proposals Listings
          </b-button>
        </div>
      </b-col>
    </b-row>

    <!-- Date and amount Form -->
    <b-card>
      <b-form @submit.prevent>
        <b-row>
          <b-col md="3">
            <h5 class="mb-2 text-primary">
              <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
              Target Compilation date
            </h5>

          </b-col>
          <b-col md="3">
              <b-form-input
                id="listingname"
                placeholder="Date Range"
                value="12/12/2019 - 12/12/2020"
              />
            </b-col>
          <b-col md="3">
            <h5 class="mb-2 text-primary">
              <feather-icon icon="ChevronsUpIcon" size="18" class="mr-50" />
              Target Budget
            </h5>
          </b-col>
          <b-col md="3">
              <b-form-input
                id="listingname"
                placeholder="Budget"
                value="10000 - 1000000"
              />
            </b-col>
        </b-row>
      </b-form>
    </b-card>
    <!-- Table -->
    <b-card title="Latest Proposals" no-body>
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
                <b-button :disabled="!filter" @click="filter = ''">
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
                placeholder=" Date"
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

          <!-- sorting  -->
          <!-- <b-form-group
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
              <b-form-select v-model="sortDesc" size="md" :disabled="!sortBy">
                <option :value="false">Asc</option>
                <option :value="true">Desc</option>
              </b-form-select>
            </b-input-group>
          </b-form-group> -->
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
        <template #cell(contractor_image)="data">
          <b-avatar :src="data.value" class="mx-1" />
        </template>
        <template #cell(contractor_name)="data">
          <span class="text-nowrap">{{ data.value }}</span>
        </template>
        <template #cell(target_budget)="data">
          <div class="border">
            {{ data.value }}
          </div>
        </template>
        <template #cell(actions)>
          <b-button
            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
            variant="primary"
            :to="{ name: 'proposals.detail' }"
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
  BFormDatepicker,
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
    BFormDatepicker,
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
      fields: [
        {
          key: "id",
          label: "Id",
        },
        {
          key: "contractor_image",
          label: "",
        },
        {
          key: "contractor_name",
          label: "Contractor Name",
        },
        { key: "target_budget", label: "Target Budget" },
        { key: "location", label: "Location", sortable: true },
        "target_date",
        { key: "proposal_date", label: "Proposal Date", sortable: true },
        {
          key: "actions",
          label: "Actions",
        },
      ],
      /* eslint-disable global-require */
      items: [
        {
          id: 1,
          contractor_image: require("@/assets/images/avatars/10-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 2,
          contractor_image: require("@/assets/images/avatars/1-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 3,
          contractor_image: require("@/assets/images/avatars/9-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 4,
          contractor_image: require("@/assets/images/avatars/3-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 5,
          contractor_image: require("@/assets/images/avatars/4-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 6,
          contractor_image: require("@/assets/images/avatars/5-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 7,
          contractor_image: require("@/assets/images/avatars/7-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 8,
          contractor_image: require("@/assets/images/avatars/9-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 9,
          contractor_image: require("@/assets/images/avatars/2-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
        },
        {
          id: 10,
          contractor_image: require("@/assets/images/avatars/6-small.png"),
          contractor_name: "Korrie O'Crevy",
          target_budget: "100000 - 10000000",
          location: "Nuclear Power Engineer",
          target_date: "09/23/2016",
          proposal_date: "19/02/2019",
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

<style>
</style>
