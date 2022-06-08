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
    },
    getters: {
        getContract: (state) => state.contracts,
        getIsLoading: (state) => state.isLoading,
        getIsDataLoading: (state) => state.isDataLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
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
    },
    actions: {
        // Getting All
        loadContracts({ commit }) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: 'get-contracts', method: "POST" })
                    .then((response) => {
                        console.log(response);
                        commit("setIsDataLoading", false);
                        commit("setContracts", response.data.data);
                        resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsDataLoading", false);
                        commit("setError", error);
                        reject(error);
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
                        resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsDataLoading", false);
                        commit("setError", error);
                        reject(error);
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
                            console.log(response);

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
                        reject(error);
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
                            console.log(response);

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
                        reject(error);
                    });
            });
        },


        // Updating

        // Deleting
    },
};
