<template>
    <div>
        <h2>Country weather</h2>
    </div>
</template>

<script>
import '../../../css/card.scss'

export default {
    data() {
        return {
            countires: null
        };
    },
    async created() {
        try {
            await this.$store.dispatch("getCountries", {});
            this.countires = this.$store.getters.countries;
            console.log(this.countires);

        } catch (error) {
            console.error(error);
        }
    }
};
</script>

<style scoped lang="scss">
</style>