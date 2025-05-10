<template>
    <div class="parent">
        <h1>Skills</h1>
        <div class="skills-list">
            <div v-for="skill in skills" :key="skill.id" class="card">
                <h2>{{ skill.name }}</h2>
                <div class="info">
                    <router-link class="card-link" :to="'/skills/' + skill.id">See more →</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import '../../../css/card.scss';

export default {
    name: "Skills",
    components: {

    },
    data() {
        return {
            skills: []
        }
    },
    async created() {
        try {
            await this.$store.dispatch("getSkills");
            this.skills = this.$store.getters['skills']
            console.log(this.$store.getters['skills']);

        } catch (error) {
            console.error("Failed to load skills", error);
        }
    }
}

</script>

<style scoped lang="scss">
.parent {
    padding: 2rem;
    display: grid;
    gap: 20px;

    .skills-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        padding: 2rem;
        background: #ffffff;
        transition: background 0.3s;
    }
}
</style>