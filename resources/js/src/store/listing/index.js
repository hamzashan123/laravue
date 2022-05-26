import axios from "axios";

export default {
    namespaced: true,
    state: {
        listing: {},
        message: "",
        error: "",
        isLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getListing: (state) => state.listing,
        getIsLoading: (state) => state.isLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
    },
    mutations: {
        setListing(state, listing) {
            state.listing = listing;
        },
        isLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setMessage(state, message) {
            state.message = message;
        },
        setError(state, error) {
            state.error = error;
        },
    },
    actions: {
        // Getting All
        loadListings: ({ commit }) => {
            commit("isLoading", true);
            axios({ url: "listing", method: "GET" })
                .then((resp) => {
                    const data = resp.data.data;
                    console.log(data, "Data");
                    commit("isLoading", false);
                    return commit("setListing", data);
                })
                .catch((err) => {
                    console.log(err);
                    commit("isLoading", false);
                });
        },

        // Getting Single

        // Saving
        async saveListing({ commit }, listingData) {
            await commit("isLoading", true);
            await axios({
                url: "create-listing",
                data: listingData,
                method: "post",
                headers: {
                    'Accept': "multipart/form-data, application/json, text/plain, */*",
                    'content-type': 'multipart/form-data'
                  }
            })
                .then(async (resp) => {
                    console.log(resp);
                    await commit("isCreated", true);
                    await commit("isLoading", false);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // Updating

        // Deleting
    },
};
