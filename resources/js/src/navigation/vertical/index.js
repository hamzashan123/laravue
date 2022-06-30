import { can } from "@/auth/authentication.js";
export default [
    {
        title: "Dashboard",
        route: "dashboard",
        icon: "HomeIcon",
    },
    ... can('create', 'all-user') ? [
    {
        title: 'Customers',
        route: 'customers',
        icon: 'UsersIcon',
    },
    ] : [],
    // {
    //     title: "Customers",
    //     route: "customers",
    //     icon: "UsersIcon",
    // },
    {
        title: "Listings",
        route: "listings",
        icon: "LockIcon",
    },
    {
        title : can('create', 'proposal') ? "My Proposals" :  can('read', 'all-proposal') ? "All Proposals": "Proposals",
            route: "proposals",
            icon: "ShoppingBagIcon",
    },


    {
        title : can('create', 'contract') ? "My Contracts" :  can('read', 'all-contract') ? "All Contracts": "Contracts",
        route: "contracts",
        icon: "FileTextIcon",
    },

    {
        title: "Chat",
        route: "chat",
        icon: "MessageSquareIcon",
    },
    ... can('create', 'all-account') ? [
    {
        title: 'Accounts',
        route: 'accounts',
        icon: 'UserPlusIcon',
    },
    ] : [],
    // {
    //     title: "Accounts",
    //     route: "accounts",
    //     icon: "UserPlusIcon",
    // },
    {
        title: "Settings",
        route: "settings",
        icon: "SettingsIcon",
    },
];
