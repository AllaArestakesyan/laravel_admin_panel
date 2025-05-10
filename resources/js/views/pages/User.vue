<template>
  <div class="user-details" v-if="user">
    <div class="card-box">
      <img 
      :src="user.avatar ? '/storage/' + user.avatar : '/storage/uploads/user.png'"
       alt="User avatar" class="avatar" />
      <h2>{{ user.name }} {{ user.surname }}</h2>
      <p><strong>Email:</strong> {{ user.email }}</p>
    </div>

  </div>

  <div v-else class="loading">Loading user...</div>
</template>

<script>
export default {
  data() {
    return {
      user: null
    };
  },
  async created() {
    try {
      const userId = this.$route.params.id;
      await this.$store.dispatch("getUser", userId);
      this.user = this.$store.getters.user;
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style scoped lang="scss">
.user-details {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 2rem;
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

  .avatar {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 1rem;
  }
}
</style>
