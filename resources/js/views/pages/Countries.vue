<template>
    <div v-if="countries" class="pagination-page">
        <ul class="country-list">
            <li v-for="country in countries.data" :key="country.id" class="card">
                <strong>{{ country.name }}</strong>
                <p>
                    {{ country.formatted_address }}
                </p>

                <div class="icons">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="showModals(country.name)" height="24px"
                        viewBox="0 -960 960 960" width="24px" fill="#007bff">
                        <path
                            d="M480-80q-83 0-141.5-58.5T280-280q0-48 21-89.5t59-70.5v-320q0-50 35-85t85-35q50 0 85 35t35 85v320q38 29 59 70.5t21 89.5q0 83-58.5 141.5T480-80Zm-40-440h80v-40h-40v-40h40v-80h-40v-40h40v-40q0-17-11.5-28.5T480-800q-17 0-28.5 11.5T440-760v240Z" />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" @click="deleteCountry(country.id)" height="24px"
                        viewBox="0 -960 960 960" width="24px" fill="#900">
                        <path
                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                    </svg>
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


        <div v-if="showModal" class="modal-overlay">
            <div class="modal">
                <div>
                    <div v-if="weatherData.temp">
                        <div class="weather">
                            <div class="weather-card">
                                <img :src="weatherData.icon" alt="">
                                <div>
                                    <div>
                                        <p>{{ weatherData.temp }}<sup>o</sup> </p>
                                    </div>
                                    <div>
                                        <div>
                                            <p>{{ weatherData.name }}, {{ weatherData.country }}</p>
                                            <p>{{ weatherData.localtime }}</p>
                                        </div>
                                        <div>
                                            {{ weatherData.text }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="scroll" ref="scrollRef1">
                                <div>
                                    <span>Hourly Forecast</span>
                                </div>
                                <div ref="scrollRef" class="scroll-container" @mousedown="onMouseDown"
                                    @mouseleave="onMouseLeave" @mouseup="onMouseUp" @mousemove="onMouseMove">
                                    <div v-for="h in hour" :key="h.name">
                                        <div>
                                            <span>{{ new Date(h.time).getHours() < 10 ? "0" + new
                                                Date(h.time).getHours() : new Date(h.time).getHours() }} </span>
                                                    <span> AM</span>
                                        </div>
                                        <div>
                                            <img :src="h.icon" alt="">
                                        </div>
                                        <div>
                                            <p>{{ h.temp_c }} <sup>o</sup></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <svg @click="closeModal()" class="btn" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                    width="24px" fill="#000">
                    <path
                        d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
import '../../../css/card.scss'
import '../../../css/pagination.scss'
import '../../../css/search.scss'
import { ref, reactive } from "vue";
import { useRoute, useRouter } from 'vue-router';

export default {
    data() {
        const route = useRoute();
        const router = useRouter();

        return {
            showModal: false,
            countries: null,
            currentPage: 1,
            router,
            route,
            countryName: "",
            weatherData: {},
            hour: [],
        };
    },
    async created() {
        this.currentPage = this.route.query.page || 1;
        this.fetchCountries(this.currentPage);

    },
    setup() {
        const scrollRef = ref(null);
        const state = reactive({
            isDragging: false,
            startX: 0,
            scrollLeft: 0,
        });

        const onMouseDown = (e) => {
            state.isDragging = true;
            state.startX = e.pageX - scrollRef.value.offsetLeft;
            state.scrollLeft = scrollRef.value.scrollLeft;
        };

        const onMouseLeave = () => {
            state.isDragging = false;
        };

        const onMouseUp = () => {
            state.isDragging = false;
        };

        const onMouseMove = (e) => {
            if (!state.isDragging) return;
            e.preventDefault();
            const x = e.pageX - scrollRef.value.offsetLeft;
            const walk = (x - state.startX) * 2; 
            scrollRef.value.scrollLeft = state.scrollLeft - walk;
        };

        return {
            scrollRef,
            onMouseDown,
            onMouseLeave,
            onMouseUp,
            onMouseMove,
        };
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
                await this.$store.dispatch("getCountries", { page, limit: 9 });
                this.countries = this.$store.getters.countries;
                console.log(this.countries);
            } catch (error) {
                console.error(error);
            }
        },
        async deleteCountry(id) {
            await this.$store.dispatch("deleteCountry", id);
            this.fetchCountries(this.countries.current_page);
        },
        showModals(countryName) {
            this.showModal = true;
            this.countryName = countryName;

            const apiKey = 'd2e7790ef6a84f91a5455407241311';
            const url = `https://api.weatherapi.com/v1/forecast.json?key=${apiKey}&q=${countryName}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log('=>', data);
                    console.log('===>', data.forecast.forecastday[0].hour);

                    this.weatherData = {
                        name: data.location.name,
                        country: data.location.country,
                        localtime: data.location.localtime,
                        temp: data.current.temp_c,
                        icon: 'https:' + data.current.condition.icon,
                        text: data.current.condition.text
                    };
                    this.hour = data.forecast.forecastday[0].hour.map(elm => ({
                        time: elm.time,
                        temp_c: elm.temp_c,
                        icon: 'https:' + elm.condition?.icon,
                        text: elm.condition?.text

                    }));

                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });

        },
        closeModal() {
            this.showModal = false;
        }
    }
};
</script>

<style scoped lang="scss">
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;

    .modal {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        max-width: 500px;
        height: 500px;
        width: 100%;
        position: relative;
        .btn{
            position: absolute;
            right: 10px;
            top: 10px;
        }
    }
}
</style>