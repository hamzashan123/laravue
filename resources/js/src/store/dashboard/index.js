import axios from "axios";

export default {
    namespaced: true,
    state: {
        proposals: "",
        listingProposals: '',
        message: "",
        error: "",
        isLoading: false,
        isDataLoading: false,
        notifications: {},
        isUpdated: false,
        isDeleted: false,
        newNotifications: 0
    },
    getters: {
        getProposal: (state) => state.proposals,
        getIsLoading: (state) => state.isLoading,
        getIsDataLoading: (state) => state.isDataLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getNotifications: (state) => state.notifications,
        getNewNotifications: (state) => state.newNotifications,
    },
    mutations: {
        setProposals(state, proposals) {
            state.proposals = proposals;
        },

        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setIsDataLoading(state, payload) {
            state.isDataLoading = payload;
        },
        setMessage(state, message) {
            state.message = message;
        },
        setError(state, error) {
            state.error = error;
        },
        setNotifications(state, payload) {
            state.notifications = payload;
        },
        setNewNotifications(state, payload) {
            let notSeenCount = 0
            if( payload ) {
                notSeenCount = payload.filter( notifi => notifi.seen == 0).length
            }
            state.newNotifications = notSeenCount;
        },
    },
    actions: {

        // Getting Single listing proposals
        getDashboard({ commit }) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-dashboard", method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsDataLoading", false);
                        commit("setError", error);
                        return reject(error);
                    });
            });
        },

        // Getting notifucations
        loadNotifications({ commit }) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-notification", method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setNotifications", response.data.data);
                        commit("setNewNotifications", response.data.data);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsDataLoading", false);
                        commit("setError", error);
                        return reject(error);
                    });
            });
        },

        // Getting notifucations
        seenNotifications({ commit }, ids) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "seen-notification", data: ids, method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setNotifications", response.data.data);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsDataLoading", false);
                        commit("setError", error);
                        return reject(error);
                    });
            });
        },

    },
};
