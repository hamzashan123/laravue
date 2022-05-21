import axios from "axios";

import jwt from '@/auth/jwt/useJwt'

export default {
    namespaced: true,
    state: {
        user: {},
        message: "",
        isLoading: false,
        error: "",
        token: localStorage.getItem("token") || "",
    },
    getters: {
        isLoggedIn: (state) => !!state.token,
        getMessage: (state) => state.message,
        getUser: (state) => state.user,
        getError: (state) => state.error,
        isLoading: (state) => state.isLoading,
    },
    mutations: {
        setMessage(state, message) {
            state.message = message;
        },
        setIsLoading(state, LoadText) {
            state.isLoading = LoadText;
        },
        setToken(state, token) {
            state.token = token;
        },
        setUser(state, user) {
            state.user = user;
        },
        setError(state, error) {
            state.error = error;
        },
        logout(state) {
            state.message = "";
            state.token = "";
            state.user = {};
        },
    },
    actions: {
        async login ({ commit }, user) {
            commit("setIsLoading", true);
            console.log( jwt.getToken() )

            await axios({ url: "login", data: user, method: "POST" })
                .then(async (resp) => {
                    if (resp.data.success) {
                        const token = "Bearer " + resp.data.data.token;
                        const user = JSON.stringify(resp.data.user);
                        localStorage.setItem("token", token);
                        console.log(user );
                        localStorage.setItem("userData", user);
                        axios.defaults.headers.common.Authorization = token;

                        await commit("setToken", token);
                        await commit("setUser", user);
                        await commit("setError", "");
                        await commit("setMessage", resp.data.message);
                        await commit("setIsLoading", false);
                    } else {
                        await commit("setIsLoading", false);
                        await commit("setMessage", resp.data.message);
                        await commit("setError", resp.data.message);
                        localStorage.removeItem("token");
                        console.log(resp.data.message, "Error");
                    }
                })
                .catch(async (err) => {
                    await commit("setError", err);
                    await commit("setIsLoading", false);
                    localStorage.removeItem("token");
                    console.log(err, "Error While loggin in!");
                });
        },
        async logout({commit}){
            await axios({ url: "logout", method: "POST" })
            localStorage.removeItem("token");
            localStorage.removeItem("userData");
            await commit('logout')
        }
    },
};
