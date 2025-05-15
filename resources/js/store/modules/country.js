import axios from '@/api/axios';

const country = {
    namespace: true,
    state: {
        countries: {
            data:[],
            total:0,
            limit:0,
            current_page:0,
            last_page:0
        },
    },
    mutations: {
        setCountries(state, countries) {
            state.countries = countries;
        }
    },
    actions: {
        async getCountries({ commit }, text) {
            // page=2&limit=10

            let str = '';
            str += text.page ? `page=${text.page}&` : ""
            str += text.limit ? `limit=${text.limit}` : ""

            const { data } = await axios.get(`/countries${str ? "?" + str : ""}`)
            console.log("===>", data);
            commit('setCountries', data)
        },
        async createCountry({ commit }, credentials) {
            const { data } = await axios.post(`/countries`, credentials)
            console.log("create =>",data);
        },
        async deleteCountry({ commit }, id) {
            const { data } = await axios.delete(`/countries/${id}`)
            console.log("delete =>",data);
        },
    },
    getters: {
        countries: (state) => state.countries,
    }
}

export default country;