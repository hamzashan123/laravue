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
        path: '/listings/edit/:id',
        name: 'listings.edit',
        component: () => import('@/views/listings/EditListing.vue'),
        meta: {
            navActiveLink: 'listings'
        },
    },
    {
        path: '/listings/view/:id',
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
        path: '/proposals',
        name: 'proposals',
        component: () => import('@/views/proposals/Proposals.vue'),
    },
    {
        path: '/proposals/:listingId/add',
        name: 'proposals.add',
        component: () => import('@/views/proposals/AddProposal.vue'),
        meta: {
            navActiveLink: 'proposals'
        },
    },

    {
        path: '/proposals/listing/:listingId',
        name: 'proposals.listing',
        component: () => import('@/views/proposals/ListingProposal.vue'),
        meta: {
            navActiveLink: 'proposals'
        },
    },
    {
        path: '/proposals/view/:proposalId',
        name: 'proposals.view',
        component: () => import('@/views/proposals/ViewProposal.vue'),
        meta: {
            navActiveLink: 'proposals'
        },
    },
    // {
    //     path: '/proposals/detail/:id',
    //     name: 'proposals.detail',
    //     component: () => import('@/views/proposals/DetailProposal.vue'),
    //     meta: {
    //         navActiveLink: 'proposals'
    //     },
    // },
    {
        path: '/contracts',
        name: 'contracts',
        component: () => import('@/views/contracts/Contracts.vue'),
    },
    {
        path: '/contracts/add/:id',
        name: 'contracts.add',
        component: () => import('@/views/contracts/AddContract.vue'),
        meta: {
            navActiveLink: 'contracts'
        },
    },
    {
        path: '/contracts/view/:id',
        name: 'contracts.view',
        component: () => import('@/views/contracts/ViewContract.vue'),
        meta: {
            navActiveLink: 'contracts'
        },
    },
    {
        path: '/contracts/detail/:id',
        name: 'contracts.detail',
        component: () => import('@/views/contracts/DetailContract.vue'),
        meta: {
            navActiveLink: 'contracts'
        },
    },
    // {
    //     path: '/chat',
    //     name: 'chat',
    //     component: () => import('@/views/chat/Chat.vue'),
    // },
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

router.beforeEach((to, from, next) => {
    const publicPages = ['/', '/register', '/reset', '/forgot', '/error-404'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('userData');
    const accessToken = localStorage.getItem('accessToken');
    // trying to access a restricted page + not logged in
    // redirect to login page
    if (authRequired && !loggedIn && !accessToken) {
      next('/');
    } else if (!authRequired && loggedIn ) {
        next({ name: 'dashboard' });
    } else {
      next();
    }
  });

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
