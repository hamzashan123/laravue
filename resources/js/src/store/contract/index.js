import axios from "axios";

import { can } from '@/auth/authentication.js'

export default {
    namespaced: true,
    state: {
        contracts: "",
        legalDocuments: '',
        message: "",
        error: "",
        isLoading: false,
        isDataLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
        comments: {},
        comment: '',
    },
    getters: {
        getContract: (state) => state.contracts,
        getIsLoading: (state) => state.isLoading,
        getIsDataLoading: (state) => state.isDataLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
        getComments: (state) => state.comments,
    },
    mutations: {
        setContracts(state, contracts) {
            state.contracts = contracts;
        },
        setLegalDocuments(state, contracts) {
            state.legalDocuments = contracts;
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
        setComments(state, comments) {
            state.comments = comments;
        },
    },
    actions: {
        // Getting All
        loadContracts({ commit }) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: 'get-contracts', method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setContracts", response.data.data);
                        resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsDataLoading", false);
                        commit("setError", error);
                        return reject(error);
                    });
            });
        },

        // Getting legal documents of listing
        loadLegalDocument({ commit }, id) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-legal-documents", data: id, method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setLegalDocuments", response.data.data);
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

        // uplaoding client documents
        uploadClientDoc({ commit }, clientData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "upload-legal-document",
                    data: clientData,
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

        // uplaoding contractor documents
        uploadContractorDoc({ commit }, contractorData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "upload-legal-document",
                    data: contractorData,
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

        // getting all comments
        loadComments({ commit }, listingId) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-comments", data: listingId, method: "POST" })
                    .then((response) => {
                        console.log(response);
                        commit("setIsDataLoading", false);
                        commit("setComments", response.data.data);
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

        // adding comment
        addComment({ commit, dispatch }, commentData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "post-comment",
                    data: commentData,
                    method: "post",
                })
                    .then((response) => {
                        if (response.data.success) {
                            // state.comments.unshift(response.data.data)
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
                        return  reject(error);
                    });
            });
        },

        // Getting contract details
        loadContractDetails({ commit }, id) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-contract-detail", data: id, method: "POST" })
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

         // archive legal payment documents
         archiveDocuments({ commit }, docsData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "archive-legal-documents",
                    data: docsData,
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

        // start Contract
        startContract({ commit }, ids) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "contract-started",
                    data: ids,
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

        // compelte Contract
        completeContract({ commit }, ids) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "contract-completed",
                    data: ids,
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
