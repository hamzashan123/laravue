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
    //   Auth Routes
    {
        path: '/',
        name: 'login',
        component: () => import('@/views/auth/Login.vue'),
        meta: {
          layout: 'full',
        },
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('@/views/auth/Register.vue'),
        meta: {
          layout: 'full',
        },
    },
    {
        path: '/forgot',
        name: 'forgot',
        component: () => import('@/views/auth/ForgotPassword.vue'),
        meta: {
          layout: 'full',
        },
    },
    {
        path: '/reset',
        name: 'reset',
        component: () => import('@/views/auth/ResetPassword.vue'),
        meta: {
          layout: 'full',
        },
    },
    {
        path: '/logout',
        name: 'logout',
        // component: () => import('@/views/auth/Login.vue'),
        // meta: {
        //   layout: 'full',
        // },
    },
    // Admin Dashboard routes
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
        path: '/customers/add',
        name: 'customers.add',
        component: () => import('@/views/customers/AddCustomer.vue'),
        meta: {
            navActiveLink: 'customers'
        },
    },
    {
        path: '/customers/edit',
        name: 'customers.edit',
        component: () => import('@/views/customers/EditCustomer.vue'),
        meta: {
            navActiveLink: 'customers'
        },
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
        meta: {
            navActiveLink: 'listings'
        },
    },
    {
        path: '/listings/view',
        name: 'listings.view',
        component: () => import('@/views/listings/ViewListing.vue'),
        meta: {
            navActiveLink: 'listings'
        },
    },
    {
        path: '/listings/detail',
        name: 'listings.detail',
        component: () => import('@/views/listings/DetailListing.vue'),
        meta: {
            navActiveLink: 'listings'
        },
    },
    {
        path: '/listings/detail/add-details',
        name: 'listings.add-more',
        component: () => import('@/views/listings/AddMoreDetails.vue'),
        meta: {
            navActiveLink: 'listings'
        },
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
        path: '/accounts/add',
        name: 'accounts.add',
        component: () => import('@/views/accounts/AddAccount.vue'),
        meta: {
            navActiveLink: 'accounts'
        },
    },
    {
        path: '/accounts/edit',
        name: 'accounts.edit',
        component: () => import('@/views/accounts/EditAccount.vue'),
        meta: {
            navActiveLink: 'accounts'
        },
    },
    {
      path: '/settings/account',
      name: 'settings',
      component: () => import('@/views/settings/AccountSettings.vue'),
    },
    {
      path: '/settings/profile',
      name: 'profile-setting',
      component: () => import('@/views/settings/ProfileSetting.vue'),
      meta: {
         navActiveLink: 'settings'
      },

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
