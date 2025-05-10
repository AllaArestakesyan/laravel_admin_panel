<template>
    <div class="parent"> 
        <h1>jobs</h1>
        <div class="jobs-list">
            <div v-for="job in jobs" :key="job.id" class="card">
                <h2>{{ job.title }}</h2>
                <div class="info">
                    <router-link class="card-link" :to="'/jobs/' + job.id">See more →</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import '../../../css/card.scss';

export default {
    name: "jobs",
    components: {

    },
    data() {
        return {
            jobs: []
        }
    },
    async created() {
        try {
            await this.$store.dispatch("getJobs");
            this.jobs = this.$store.getters['jobs'];
            
        } catch (error) {
            console.error("Failed to load jobs", error);
        }
    }
}

</script>

<style scoped lang="scss">
.parent{
    padding: 2rem;
    display: grid;
    gap: 20px;
    .jobs-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        background: #ffffff;
        transition: background 0.3s;
    }
}
</style>