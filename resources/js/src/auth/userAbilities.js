
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
        update: ["proposal", "visit"],
    },
    3: { // Eb Staff
        create: ["listing", "proposal", "account", "user"],
        read: ["listing", "proposal", "account", "user"],
        delete: ["listing", "proposal", "account", "user"],
        update: ["listing", "proposal", "account", "user"],
    },

};
