<template>
    <div class="job-details" v-if="job">
        <div class="card-box">
            <h2>{{ job.title }}</h2>
            <p><strong>Budget:</strong> {{ job.budget }}</p>
            <p><strong>Description:</strong> {{ job.description }}</p>
            <p><strong>Updated :</strong> {{ new Date(job.updated_at).toDateString() }}</p>
        </div>

        <div v-if="job?.skills?.length" class="job-list">
            <div v-for="skill in job.skills" :key="skill.id" class="job-box">
                <h3>{{ skill.name }}</h3>
                <router-link :to="`/skills/${skill.id}`" class="see-more">
                    See more →
                </router-link>
            </div>
        </div>
        <p v-else>No skills found in this job.</p>

    </div>

    <div v-else class="loading">Loading job...</div>
</template>

<script>
export default {
    data() {
        return {
            job: null
        };
    },
    async created() {
        try {
            const jobId = this.$route.params.id;
            await this.$store.dispatch("getJob", jobId);
            this.job = this.$store.getters.job;
            console.log(this.job);

        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<style scoped lang="scss">
.job-details {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
     .job-list {
        display: grid;
        gap: 1.5rem;
        margin-top: 2rem;

        .job-box {
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fafafa;
            transition: background 0.3s;

            &:hover {
                background: #f0f0f0;
            }

            .see-more {
                display: inline-block;
                margin-top: 0.5rem;
                color: #3f51b5;
                font-weight: 500;
                text-decoration: none;

                &:hover {
                    text-decoration: underline;
                }
            }
        }
    }
}

.card-box {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    padding: 2rem;
    max-width: 500px;
    width: 100%;
    text-align: center;
    margin-bottom: 2rem;

    &:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }

   
}
</style>
