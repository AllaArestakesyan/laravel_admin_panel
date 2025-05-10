<template>
    <div class="skill-details" v-if="skill">
        <div class="card-box">
            <h2>{{ skill.name }}</h2>
        </div>

        <div v-if="skill?.jobs?.length" class="skill-list">
            <div v-for="job in skill.jobs" :key="job.id" class="skill-box">
                <h3>{{ job.title }}</h3>
                <router-link :to="`/jobs/${job.id}`" class="see-more">
                    See more →
                </router-link>
            </div>
        </div>
        <p v-else>No jobs found in this skill.</p>

    </div>

    <div v-else class="loading">Loading skill...</div>
</template>

<script>
export default {
    data() {
        return {
            skill: null
        };
    },
    async created() {
        try {
            const skillId = this.$route.params.id;
            await this.$store.dispatch("getSkill", skillId);
            this.skill = this.$store.getters.skill;
            console.log(this.skill);

        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<style scoped lang="scss">
.skill-details {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
     .skill-list {
        display: grid;
        gap: 1.5rem;
        margin-top: 2rem;

        .skill-box {
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
