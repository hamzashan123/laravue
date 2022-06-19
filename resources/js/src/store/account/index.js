import axios from "axios";

import { can } from '@/auth/authentication.js'

export default {
    namespaced: true,
    state: {
        accounts: "",
        message: "",
        error: "",
        isLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getAccount: (state) => state.accounts,
        getIsLoading: (state) => state.isLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
    },
    mutations: {
        setAccounts(state, accounts) {
            state.accounts = accounts;
        },
        setIsLoading(state, isLoading) {
            state.isLoading = isLoading;
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
        loadAccounts({ commit }) {
            return new Promise((resolve, reject) => {
                axios({ url: 'get-users', method: "POST" })
                    .then((response) => {
                        console.log(response);
                        commit("setIsLoading", false);
                        commit("setAccounts", response.data.data);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsLoading", false);
                        commit("setError", error);
                        return reject(error);
                    });
            });
        },

        // Getting Single
        loadAccount({ commit }, ids) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "getaccountbyid", data: ids, method: "POST" })
                    .then((response) => {
                        commit("setIsLoading", false);
                        commit("setAccounts", response.data.data);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsLoading", false);
                        commit("setError", error);
                        return reject(error);
                    });
            });
        },

        // Saving
        saveAccount({ commit }, accountData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "create-accounts",
                    data: accountData,
                    method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        if (response.data.success) {

                            commit("setIsCreated", true);
                            commit("setMessage", response.data.message);
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        } else {
                            commit("setIsCreated", false);
                            commit("setError", response.data.message);
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
        updateAccount({ commit }, accountData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "update-account",
                    data: accountData,
                    method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        if (response.data.success) {

                            commit("setIsCreated", true);
                            commit("setMessage", response.data.message);
                            commit("setIsLoading", false);
                            return resolve(response.data);
                        } else {
                            commit("setIsCreated", false);
                            commit("setError", response.data.message);
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

        // Deleting
    },
};
