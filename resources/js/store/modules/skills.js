import axios from '@/api/axios';

const skill = {
    namespace:true,
    state: {
        skill: null,
        currentskill: null,
        skills: []
    },
    mutations: {
        setSkills(state, skill) {
            state.skills = skill;
        },
        setSkill(state, skill) {
            state.skill = skill;
        },
    },
    actions: {
        async getSkills({ commit }) {
            const {data} = await axios.get('/skills')
            commit('setSkills', data)
        },
        async getskill({ commit }, id) {
            const {data} = await axios.get(`/skills/${id}`)
            commit('setSkill', data)
        },
    },
    getters: {
        skills: (state) => state.skills,
        skill: (state) => state.skill,
    }
}

export default skill;