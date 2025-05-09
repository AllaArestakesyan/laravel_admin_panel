import { createStore } from 'vuex';
import axios from '@/api/axios';
import Cookies from 'js-cookie';


const auth = {
    namespace: true,
    state: {
        user: null,
        done:false
    },
    mutations: {
        setCurrentUser(state, user) {
            state.currentUser = user;
        },
        setDone(state, done) {
            state.done = done;
        },
        logout(state) {
            state.currentUser = null
        },

    },
    actions: {
        async login({ commit }, credentials) {
            console.log(credentials);
            
            const { data } = await axios.post('/login', credentials)
            if("access_token" in data){
                Cookies.set('access_token', data.access_token)
                commit("setDone", true)
            }else{
                commit("setDone", false)
            }
        },
        async register({ commit }, credentials) {
            const { data } = await axios.post('/register', credentials)
            return data;
        },
        async profile({ commit }) {
            const { data } = await axios.get('/profile');
            commit('setCurrentUser', data)
        },
        async logout({ commit }) {
            const { data } = await axios.post('/logout')
            Cookies.remove("access_token")
            commit('logout')
        },
        async updateCurrentUserData({ commit }, credentials) {
            const { data } = await axios.put(`/users`, credentials)
            commit('setCurrentUser', data)
        },
        async updateCurrentUserAvatar({ commit }, credentials) {
            const { data } = await axios.post(`/users/avatar`, credentials)
            commit('setCurrentUser', data)
        },
        async deleteCurrentUserAccount({ commit }) {
            const { data } = await axios.delete(`/users`)
            Cookies.remove("access_token")
            commit('logout')
        }
    },
    getters: {
        isAuthenticated: (state) => !!state.currentUser,
        currentUser: (state) => state.currentUser,
        done: (state) => state.done,
    }
}

export default auth;