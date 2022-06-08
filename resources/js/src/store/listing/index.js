import axios from "axios";

import { can } from '@/auth/authentication.js'

export default {
    namespaced: true,
    state: {
        listings: "",
        message: "",
        error: "",
        isLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getListing: (state) => state.listings,
        getIsLoading: (state) => state.isLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
    },
    mutations: {
        setListings(state, listings) {
            state.listings = listings;
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
        loadListings({ commit }) {
            commit("setIsLoading", true);
            let endpoint = 'get-listing'
            if( can("create", "proposal") ){
                endpoint = 'get-published-listings'
            } else if( can("create", "listing") ){
                endpoint = 'my-listings'
            } else if( can("create", "all-listing") ){
                endpoint = 'get-listing'
            }
            return new Promise((resolve, reject) => {
                axios({ url: endpoint, method: "POST" })
                    .then((response) => {
                        commit("setIsLoading", false);
                        commit("setListings", response.data.data);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsLoading", false);
                        commit("setError", error);
                        reject(error);
                    });
            });
        },

        // Getting Single
        loadListing({ commit }, ids) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "getlistingbyid", data: ids, method: "POST" })
                    .then((response) => {
                        commit("setIsLoading", false);
                        commit("setListings", response.data.data);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                        commit("setIsLoading", false);
                        commit("setError", error);
                        reject(error);
                    });
            });
        },

        // Saving
        saveListing({ commit }, listingData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "create-listings",
                    data: listingData,
                    method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response);

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
                        reject(error);
                    });
            });
        },

        // publish listing
        publishLising({commit}, draftListingId) {
            commit("setIsLoading", true)
            return new Promise((resolve, reject) => {
                axios({ url: 'publish-listing', data: draftListingId, method: 'post' })
                    .then(( response ) => {
                        console.log(response);
                        commit("setIsLoading", false)
                        return resolve( response.data )
                    })
                    .catch((error) => {
                        commit("setIsLoading", false)
                        console.log(error)
                        reject(error)
                     })
            })
        },

        // Updating
        updateListing({ commit }, listingData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "update-listing",
                    data: listingData,
                    method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response);

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
                        reject(error);
                    });
            });
        },

        // upload visits of lsiting
        uploadVisit({ commit }, visitData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "upload-listing-visit",
                    data: visitData,
                    method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response);

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
                        reject(error);
                    });
            });
        },

        // Deleting
    },
};
