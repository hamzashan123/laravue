import axios from "axios";

export default {
    namespaced: true,
    state: {
        user: {},
        roleId: '',
        message: "",
        isLoading: false,
        error: "",
        isLoggedIn: false,
    },
    getters: {
        getMessage: (state) => state.message,
        roleId: (state) => state.roleId,
        getUser: (state) => state.user,
        getError: (state) => state.error,
        isLoading: (state) => state.isLoading,
        isLoggedIn: (state) => state.isLoggedIn,

    },
    mutations: {
        setMessage(state, message) {
            state.message = message;
        },
        setIsLoading(state, LoadText) {
            state.isLoading = LoadText;
        },
        setUser(state, user) {
            state.user = user;
        },
        setRoleId(state, id) {
            state.roleId = id;
        },
        setError(state, error) {
            state.error = error;
        },
        isLoggedIn(state, isLoggedIn) {
            state.isLoggedIn = isLoggedIn;
        },
        logout(state) {
            state.message = "";
            state.user = {};
        },
    },
    actions: {
        async login ({ commit }, user) {
            commit("setIsLoading", true);

            await axios({ url: "login", data: user, method: "POST" })
                .then(async (resp) => {
                    if (resp.data.success) {
                        const accessToken = "Bearer " + resp.data.data.token;
                        const user = JSON.stringify(resp.data.user);
                        localStorage.setItem("accessToken", accessToken);
                        localStorage.setItem("userData", user);
                        axios.defaults.headers.common.Authorization = accessToken;

                        await commit("isLoggedIn", true);

                        await commit("setUser", user);
                        await commit("setRoleId", resp.data.user.user_role.id);
                        // console.log(resp.data.user.user_role.id);
                        await commit("setError", "");
                        await commit("setMessage", resp.data.message);
                        await commit("setIsLoading", false);
                    } else {
                        await commit("setIsLoading", false);
                        await commit("setMessage", resp.data.message);
                        await commit("setError", resp.data.message);
                        localStorage.removeItem("accessToken");
                        console.log(resp.data.message, "Error");
                    }
                })
                .catch(async (err) => {
                    await commit("setError", err);
                    await commit("setIsLoading", false);
                    localStorage.removeItem("accessToken");
                    console.log(err, "Error While loggin in!");
                });
        },

        // registerData
        register({ commit }, registerData) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "register",
                    data: registerData,
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

        // Logout
        async logout({commit}){
            await axios({ url: "logout", method: "POST" })
            localStorage.removeItem("accessToken");
            localStorage.removeItem("userData");
            await commit('logout')
        },


        // forgot password send email
        resetPassword({ commit }, data) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "reset-password",
                    data: data,
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

        // verify code form email
        verifyCode({ commit }, data) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "verify-reset-password-code",
                    data: data,
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

        // forgot password send email
        changePassword({ commit }, data) {
            commit("setIsLoading", true);
            return new Promise((resolve, reject) => {
                axios({
                    url: "change-password",
                    data: data,
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
    },
};
