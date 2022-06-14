import axios from "axios";

export default {
    namespaced: true,
    state: {
        message: "",
        error: "",
        isLoading: false,
        isDataLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
        chats: {},
    },
    getters: {
        getIsLoading: (state) => state.isLoading,
        getIsDataLoading: (state) => state.isDataLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
        getChats: (state) => state.chats,
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
        setChats(state, chats) {
            state.chats = chats;
        },
    },
    actions: {

        // getting all chats
        loadChats({ commit }) {
            commit("setIsDataLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "get-messages", method: "POST" })
                    .then((response) => {
                        commit("setIsDataLoading", false);
                        commit("setChats", response.data.data);
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

        // adding chat
        addChat({ commit, dispatch }, chatData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "send-message",
                    data: chatData,
                    method: "post",
                })
                    .then((response) => {
                        if (response.data.success) {
                            console.log(response);
                            dispatch('loadChats')
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
    },
};