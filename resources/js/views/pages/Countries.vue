<template>
    <div v-if="countries" class="pagination-page">
        <ul class="country-list">
            <li v-for="country in countries.data" :key="country.id" class="card">
                <strong>{{ country.name }}</strong> 
                <p>
                    {{ country.formatted_address }}
                </p>

                
                <div class="icons">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#007bff"><path d="M480-80q-83 0-141.5-58.5T280-280q0-48 21-89.5t59-70.5v-320q0-50 35-85t85-35q50 0 85 35t35 85v320q38 29 59 70.5t21 89.5q0 83-58.5 141.5T480-80Zm-40-440h80v-40h-40v-40h40v-80h-40v-40h40v-40q0-17-11.5-28.5T480-800q-17 0-28.5 11.5T440-760v240Z"/></svg>

                    <svg xmlns="http://www.w3.org/2000/svg" @click="deleteCountry(country.id)" height="24px" viewBox="0 -960 960 960" width="24px" fill="#900"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                </div>
            </li>
        </ul>

        <div class="pagination">
            <button class="page-btn" :disabled="countries.current_page === 1"
                @click="changePage(countries.current_page - 1)">
                Prev
            </button>

            <button class="page-btn" v-for="page in countries.last_page" :key="page"
                :class="{ active: page === countries.current_page }" @click="changePage(page)">
                {{ page }}
            </button>

            <button class="page-btn" :disabled="countries.current_page === countries.last_page"
                @click="changePage(countries.current_page + 1)">
                Next
            </button>
        </div>


    </div>
</template>

<script>
import '../../../css/card.scss'
import '../../../css/pagination.scss'
import { useRoute, useRouter } from 'vue-router';

export default {
    data() {
        const route = useRoute();
        const router = useRouter();

        return {
            countries: null,
            currentPage: 1,
            router,
            route
        };
    },
    async created() {
        this.currentPage = this.route.query.page || 1;
        this.fetchCountries(this.currentPage);

    },
    methods: {
        changePage(page) {
            if (page >= 1 && page <= this.countries.last_page) {
                this.router.push({ query: { ...this.route.query, page } });
                this.fetchCountries(page);
            }
        },
        async fetchCountries(page = 1) {
            try {
                await this.$store.dispatch("getCountries", { page, limit:9 });
                this.countries = this.$store.getters.countries;
                console.log(this.countries);
            } catch (error) {
                console.error(error);
            }
        },
        async deleteCountry(id){
            await this.$store.dispatch("deleteCountry", id);
            this.fetchCountries(this.countries.current_page);
        }
    }
};
</script>

<style scoped lang="scss">

</style>