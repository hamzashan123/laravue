import { can } from '@/auth/authentication.js'
export default [
  {
    title: 'Dashboard',
    route: 'dashboard',
    icon: 'HomeIcon',
  },
  ... can('create', 'user') ? [
    {
        title: 'Customers',
        route: 'customers',
        icon: 'UsersIcon',
    },
  ] : [],
  {
    title: 'Listings',
    route: 'listings',
    icon: 'LockIcon',
  },
  {
    title: 'Proposals',
    route: 'proposals',
    icon: 'ShoppingBagIcon',
  },
  ... can('create', 'account') ? [
    {
        title: 'Accounts',
        route: 'accounts',
        icon: 'UserPlusIcon',
    },
  ] : [],
  {
    title: 'Settings',
    route: 'settings',
    icon: 'SettingsIcon',
  },
]
