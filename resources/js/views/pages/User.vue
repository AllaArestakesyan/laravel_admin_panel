<template>
    <div class="user-details" v-if="user">
        <div class="card-box">
            <img :src="'http://127.0.0.1:8000/storage/' + user.avatar" alt="User avatar" class="avatar" />
            <h2>{{ user.name }} {{ user.surname }}</h2>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Phone:</strong> +{{ user.country_code }} {{ user.phone_number }}</p>
            <p><strong>Country:</strong> {{ user.country_name }}</p>
            <p><strong>Role:</strong> {{ user.role }}</p>
        </div>

        <div class="products" v-if="user.products.length">
            <h3>User's Products</h3>
            <div class="product-card" v-for="product in user.products" :key="product.id">
                <h4>{{ product.name }}</h4>
                <p>{{ product.description }}</p>
            </div>
        </div>

        <div v-else class="no-products">
            <p>This user has no products.</p>
        </div>
    </div>

    <div v-else class="loading">Loading user...</div>
</template>
  
<script setup >
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from 'vuex'

const store = useStore();
const route = useRoute()

const user = computed(() => store.getters["user"])

onMounted(async () => {
    try {
        const userId = route.params.id
        await store.dispatch("getUser", userId)
    } catch (error) {
        console.error(error)
    }
})

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

.products {
    max-width: 600px;
    width: 100%;
    display: grid;
    gap: 1rem;
}

.product-card {
    background: #f9f9f9;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    transition: all .4s ease-in-out;

    &:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    }
}
</style>