<template>
  <div class="users-list">
    <UserCard v-for="user in users" :key="user.email" :user="user" />
  </div>
</template>

<script>
import UserCard from '../../components/UserCard.vue';

export default {
  components: {
    UserCard
  },
  data() {
    return {
      users: []
    };
  },
  async created() {
    try {
      await this.$store.dispatch("getUsers");
      this.users = this.$store.getters["users"];
      console.log(this.$store.getters["users"]);
      
    } catch (error) {
      console.error("Failed to load users", error);
    }
  }
};
</script>

<style scoped lang="scss">
.users-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 2rem;
  padding: 2rem;
  background: #ffffff;
  transition: background 0.3s;
}
</style>
