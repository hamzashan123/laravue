import axios from "axios";

import { can } from '@/auth/authentication.js'

export default {
    namespaced: true,
    state: {
        proposals: "",
        listingProposals: '',
        message: "",
        error: "",
        isLoading: false,
        isDataLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getProposal: (state) => state.proposals,
        getIsLoading: (state) => state.isLoading,
        getIsDataLoading: (state) => state.isDataLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
    },
    mutations: {
        setProposals(state, proposals) {
            state.proposals = proposals;
        },
        setListingProposals(state, proposals) {
            state.listingProposals = proposals;
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
        setIsCreated(state, isCreated) {
            state.isCreated = isCreated;
        },
    },
    actions: {
        // Getting All
        loadProposals({ commit }) {
            commit("setIsDataLoading", true);
            let endpoint = ''
            if( can("create", "proposal") ){
                endpoint = 'get-proposals'
            } else if( can("create", "listing") ){
                endpoint = 'get-proposals'
            } else if( can("create", "all-listing") ){
                endpoint = 'get-proposals'
            }
            return new Promise((resolve, reject) => {
                axios({ url: endpoint, method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setProposals", response.data.data);
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

        // Getting Single listing proposals
        loadListingProposals({ commit }, ids) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-listing-proposals", data: ids, method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setListingProposals", response.data.data);
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

        // Getting Single proposal detail
        loadProposal({ commit }, id) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-proposal-details", data: id, method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setListingProposals", response.data.data);
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

         // Saving/ Send proposal
         sendProposal({ commit }, proposalData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "send-proposal",
                    data: proposalData,
                    method: "post",
                })
                    .then((response) => {
                        if (response.data.success) {

                            commit("setIsLoading", false);
                            return resolve(response.data);
                        } else {
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setError", error);
                        commit("setIsLoading", false);
                        return reject(error);
                    });
            });
        },

        // approve propsoal
        approveProposal({ commit }, proposalId) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "approve-proposal",
                    data: proposalId,
                    method: "post",
                })
                    .then((response) => {
                        if (response.data.success) {

                            commit("setIsLoading", false);
                            return resolve(response.data);
                        } else {
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setError", error);
                        commit("setIsLoading", false);
                        return reject(error);
                    });
            });
        },

        // reject / deny propsoal
        rejectProposal({ commit }, proposalId) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "deny-proposal",
                    data: proposalId,
                    method: "post",
                })
                    .then((response) => {
                        if (response.data.success) {

                            commit("setIsLoading", false);
                            return resolve(response.data);
                        } else {
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setError", error);
                        commit("setIsLoading", false);
                        return reject(error);
                    });
            });
        },

        // assign contract
        assignContract({ commit }, assignData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "assign-contract",
                    data: assignData,
                    method: "post",
                })
                    .then((response) => {
                        if (response.data.success) {
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        } else {
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setError", error);
                        commit("setIsLoading", false);
                        return reject(error);
                    });
            });
        },


        // Updating

        // Deleting
    },
};
