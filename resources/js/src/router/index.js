import Vue from 'vue'
import VueRouter from 'vue-router'

import AddListing from '@/views/listings/AddListing.vue'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
        path: '/',
        name: 'login',
        component: () => import('@/views/auth/Login.vue'),
        meta: {
          layout: 'full',
        },
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@/views/Dashboard.vue'),
    },
    {
      path: '/customers',
      name: 'customers',
      component: () => import('@/views/customers/Customers.vue'),
    },
    {
      path: '/listings',
      name: 'listings',
      component: () => import('@/views/listings/Listings.vue'),
    },
    {
        path: '/listings/add',
        name: 'listings.add',
        component: AddListing,
    },
    {
        path: '/listings/view',
        name: 'viewListing',
        component: () => import('@/views/listings/ViewListing.vue'),
    },
    {
        path: '/listings/detail',
        name: 'detailListing',
        component: () => import('@/views/listings/DetailListing.vue'),
    },
    {
      path: '/accounts',
      name: 'accounts',
      component: () => import('@/views/accounts/Accounts.vue'),
    //   meta: {
    //     pageTitle: 'Accounts',
    //     breadcrumb: [
    //       {
    //         text: 'Accounts',
    //         active: true,
    //       },
    //     ],
    //   },
    },
    {
      path: '/settings',
      name: 'settings',
      component: () => import('@/views/settings/Settings.vue'),
    },
    {
      path: '/blank',
      name: 'blank-page',
      component: () => import('@/views/BlankPage.vue'),
    },
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '*',
      redirect: 'error-404',
    },
  ],
})

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})

export default router
