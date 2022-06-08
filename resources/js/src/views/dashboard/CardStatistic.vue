<template>
  <div>
    <!-- Miscellaneous Charts -->
    <b-row class="match-height">
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
    </b-row>
    <!--/ Miscellaneous Charts -->

    <!-- Stats Card Vertical -->
    <b-row class="match-height">
      <b-col
        xl="2"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          icon="EyeIcon"
          statistic="25"
          statistic-title="Customer"
          color="info"
        />
      </b-col>
      <b-col
        xl="2"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="warning"
          icon="MessageSquareIcon"
          statistic="12"
          statistic-title="Contractors"
        />
      </b-col>
      <b-col
        xl="2"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="danger"
          icon="ShoppingBagIcon"
          statistic="235"
          statistic-title="Listings"
        />
      </b-col>
      <b-col
        xl="2"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="primary"
          icon="HeartIcon"
          statistic="5"
          statistic-title="Eb Staff"
        />
      </b-col>
      <b-col
        xl="2"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          color="success"
          icon="AwardIcon"
          statistic="689"
          statistic-title="Projects Completed"
        />
      </b-col>
      <b-col
        xl="2"
        md="4"
        sm="6"
      >
        <statistic-card-vertical
          hide-chart
          color="danger"
          icon="TruckIcon"
          statistic="2"
          statistic-title="Rejected Proejcts"
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
      // Area charts
      subscribersGained: {},
      revenueGenerated: {},
      quarterlySales: {},
      ordersRecevied: {},

      // Line Charts
      siteTraffic: {},
      activeUsers: {},
      newsletter: {},
    }
  },
  created() {
    // Subscribers gained
    this.$http.get('/card/card-statistics/subscribers')
      .then(response => { this.subscribersGained = response.data })

    // Revenue Generated
    this.$http.get('/card/card-statistics/revenue')
      .then(response => { this.revenueGenerated = response.data })

    // Sales
    this.$http.get('/card/card-statistics/sales')
      .then(response => { this.quarterlySales = response.data })

    // Orders
    this.$http.get('/card/card-statistics/orders')
      .then(response => { this.ordersRecevied = response.data })

    // Site Traffic gained
    this.$http.get('/card/card-statistics/site-traffic')
      .then(response => { this.siteTraffic = response.data })

    // Active Users
    this.$http.get('/card/card-statistics/active-users')
      .then(response => { this.activeUsers = response.data })

    // Newsletter
    this.$http.get('/card/card-statistics/newsletter')
      .then(response => { this.newsletter = response.data })
  },
  methods: {
    kFormatter,
  },
}
</script>
