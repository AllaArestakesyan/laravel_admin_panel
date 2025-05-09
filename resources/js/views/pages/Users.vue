<template>
    <div class="users-list">
        <UserCard v-for="user in users" :key="user.email" :user="user" />
    </div>
</template>
  
<script setup >
import UserCard from '../../components/UserCard.vue';
import { useStore } from 'vuex'
import { computed, onMounted } from 'vue'

const store = useStore();

const users = computed(() => store.getters["users"])

onMounted(async () => {
    await store.dispatch("getUsers")
})

</script>
  
<style lang="scss" scoped>
.users-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    padding: 2rem;
    background: #ffffff;
    transition: background 0.3s;

}
</style>
  