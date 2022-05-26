import axios from "axios";

export default {
    namespaced: true,
    state: {
        listing: {},
        isLoading: false,
        message: "",
        error: "",
    },
    getters: {
        getListing: (state) => state.listing,
        getIsLoading: ( state ) => state.isLoading,
        getMessage: ( state ) => state.message,
        getError: ( state ) => state.error
    },
    mutations: {

    },
    actions: {
        // Getting All

        // Getting Single

        // Saving

        // Updating

        // Deleting

    },
};
