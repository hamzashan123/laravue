<template>
  <div>
    <!-- Miscellaneous Charts -->
    <!-- <b-row class="match-height">
      <b-col
        lg="2"
        cols="6"
      >
        <card-statistic-order-chart />
      </b-col>
      <b-col
        lg="2"
        cols="6"
      >
        <card-statistic-profit-chart />
      </b-col>
      <b-col
        lg="8"
        cols="12"
      >
        <card-statistics-group />
      </b-col>
    </b-row> -->
    <!--/ Miscellaneous Charts -->

    <!-- Stats Card Vertical -->
    <b-row class="match-height">
      <b-col

        xl="3"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          icon="LockIcon"
          :statistic="dashboard.totallistings"
          statistic-title="Total Listings"
          color="info"
        />
      </b-col>
      <b-col
        v-if="loggedinUser ? loggedinUser.user_role.id == 3 : ''"
        xl="3"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="warning"
          icon="UsersIcon"
          :statistic="dashboard.totalclients"
          statistic-title="Total Clients"
        />
      </b-col>
      <b-col
        v-if="loggedinUser ? loggedinUser.user_role.id == 3 : ''"
        xl="3"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="danger"
          icon="BriefcaseIcon"
          :statistic="dashboard.totalcontractors"
          statistic-title="Total Contractors"
        />
      </b-col>
      <b-col
        v-if="loggedinUser ? loggedinUser.user_role.id == 3 : ''"
        xl="3"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="primary"
          icon="HeartIcon"
          :statistic="dashboard.totalstaff"
          statistic-title="Total Eb Staff"
        />
      </b-col>
      <b-col
        v-if="loggedinUser ? loggedinUser.user_role.id == 3 : ''"
        xl="3"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="primary"
          icon="UsersIcon"
          :statistic="dashboard.totalusers"
          statistic-title="Total Users"
        />
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import StatisticCardVertical from '@core/components/statistics-cards/StatisticCardVertical.vue'
import StatisticCardHorizontal from '@core/components/statistics-cards/StatisticCardHorizontal.vue'
import StatisticCardWithAreaChart from '@core/components/statistics-cards/StatisticCardWithAreaChart.vue'
import StatisticCardWithLineChart from '@core/components/statistics-cards/StatisticCardWithLineChart.vue'
import { kFormatter } from '@core/utils/filter'
import CardStatisticOrderChart from './CardStatisticOrderChart.vue'
import CardStatisticProfitChart from './CardStatisticProfitChart.vue'
import CardStatisticsGroup from './CardStatisticsGroup.vue'

import { mapGetters, mapActions } from "vuex";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default {
  components: {
    BRow,
    BCol,
    StatisticCardVertical,
    StatisticCardHorizontal,
    StatisticCardWithAreaChart,
    StatisticCardWithLineChart,
    CardStatisticOrderChart,
    CardStatisticProfitChart,
    CardStatisticsGroup,
  },
  data() {
    return {
       loggedinUserRole: '',
       loggedinUser: '',
      // Area charts
      subscribersGained: {},
      revenueGenerated: {},
      quarterlySales: {},
      ordersRecevied: {},

      dashboard: {
        totalclients: '',
        totalcontractors: '',
        totallistings: '',
        totalstaff: '',
        totalusers: '',
      },

    }
  },
  computed: {
        ...mapGetters({
            isLoading: "listing/getIsLoading",
            isDataLoading: "proposal/getIsDataLoading"
        }),
    },
  mounted() {
        // getting loggedin user
        const getUser = JSON.parse(localStorage.getItem("userData"));
        this.loggedinUser = getUser
        const userRole = getUser.user_role;
        this.loggedinUserRole = userRole

       // getting dashboard
        this.getDashboard()
            .then((response) => {
                if (response) {
                    this.dashboard = response.data;
                    // console.log(this.dashboard);
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
  methods: {
    kFormatter,

    ...mapActions({ getDashboard: "dashboard/getDashboard" }),
  },
}
</script>
