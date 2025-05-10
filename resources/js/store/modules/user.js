import axios from '@/api/axios';

const user = {
    namespace:true,
    state: {
        user: null,
        users: []
    },
    mutations: {
        setUsers(state, users) {
            state.users = users;
        },
        setUser(state, user) {
            state.user = user;
        },
    },
    actions: {
        async getUsers({ commit }) {
            const {data} = await axios.get('/users')
            commit('setUsers', data)
        },
        async getUser({ commit }, id) {
            const {data} = await axios.get(`/users/${id}`)
            commit('setUser', data)
        },
    },
    getters: {
        users: (state) => state.users,
        user: (state) => state.user,
    }
}

export default user;