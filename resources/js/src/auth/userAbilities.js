
// const userRoles = { admin: "admin", client: 1, contractor: 2, ebstaff: 3 };

export const userAbilities = {

    1: { // client
        create: ["listing"],
        read: ["listing", "proposal"],
        delete: ["listing"],
        update: ["listing"],
    },
    2: { // Contractor
        create: ["proposal", ],
        read: ["proposal"],
        delete: ["proposal"],
        update: ["proposal"],
    },
    3: { // Eb Staff
        create: ["all-listing", "all-proposal", "all-visit", "all-account", "all-user", "all-contract"],
        read: ["all-listing", "all-proposal",  "all-visit", "all-account", "all-user", "all-contract"],
        delete: ["all-listing", "all-proposal", "all-visit", "all-account", "all-user", "all-contract"],
        update: ["all-listing", "all-proposal", "all-visit", "all-account", "all-user", "all-contract"],
    },

};
