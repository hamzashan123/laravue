import axios from "axios";

export default {
    namespaced: true,
    state: {
        user: {},
        message: "",
        error: "",
        isLoading: false,
        isCreated: false,
        isUpdated: false,
        isDeleted: false,
    },
    getters: {
        getUser: (state) => state.user,
        getIsLoading: (state) => state.isLoading,
        getMessage: (state) => state.message,
        getError: (state) => state.error,
        getIsCreated: (state) => state.isCreated,
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
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

        // Getting Single

        // Saving

        // Updating
        updateProfile({ commit }, profileData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "updateProfile", data: profileData, method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        commit("setIsLoading", false);
                        const user = JSON.stringify(response.data.data);
                        localStorage.setItem("userData", user);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error, "in axios error");
                        commit("setIsLoading", false);
                        reject(error);
                    });
            });
        },

        // Update password
        updatePassword({ commit }, PassData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({ url: "updateProfile", data: PassData, method: "post",
                    headers: {
                        Accept: "*/*",
                        "Content-type": "multipart/form-data charset=utf-8; boundary=" + Math.random().toString().substr(2),
                    },
                })
                    .then((response) => {
                        commit("setIsLoading", false);
                        return resolve(response.data);
                    })
                    .catch((error) => {
                        console.log(error, "in axios error");
                        commit("setIsLoading", false);
                        reject(error);
                    });
            });
        },

        // Deleting

    },
};
