import axios from "axios";

export default {
    namespaced: true,
    state: {
        proposals: "",
        message: "",
        error: "",
        isLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getProposal: (state) => state.proposals,
        getIsLoading: (state) => state.isLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
    },
    mutations: {
        setProposals(state, proposals) {
            state.proposals = proposals;
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
        loadProposals({ commit }) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-proposals", method: "POST" })
                    .then((response) => {
                        commit("setIsLoading", false);
                        commit("setProposals", response.data.data);
                        resolve(response.data);
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
        loadProposal({ commit }, ids) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "getproposalbyid", data: ids, method: "POST" })
                    .then((response) => {
                        commit("setIsLoading", false);
                        commit("setProposals", response.data.data);
                        resolve(response.data);
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

        // publish proposal
        publishLising({commit}, draftProposalId) {
            commit("setIsLoading", true)
            return new Promise((resolve, reject) => {
                axios({ url: 'publish-proposal', data: draftProposalId, method: 'post' })
                    .then(( response ) => {
                        console.log(response);
                        commit("setIsLoading", false)
                        resolve( response.data )
                    })
                    .catch((error) => {
                        commit("setIsLoading", false)
                        console.log(error)
                        reject(error)
                     })
            })
        }

        // Updating

        // Deleting
    },
};
