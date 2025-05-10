import axios from '@/api/axios';

const job = {
    namespace:true,
    state: {
        job: null,
        jobs: []
    },
    mutations: {
        setJobs(state, jobs) {
            state.jobs = jobs;
        },
        setJob(state, job) {
            state.job = job;
        },
    },
    actions: {
        async getJobs({ commit }) {
            const {data} = await axios.get('/jobs')
            commit('setJobs', data)
        },
        async getJob({ commit }, id) {
            const {data} = await axios.get(`/jobs/${id}`)
            commit('setJob', data)
        },
    },
    getters: {
        jobs: (state) => state.jobs,
        job: (state) => state.job,
    }
}

export default job;