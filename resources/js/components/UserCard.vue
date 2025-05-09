<template>
    <div class="card">
        <img :src="'http://127.0.0.1:8000/storage/' + user.avatar" alt="User avatar" class="avatar"
            @error="e => (e.target.src = 'http://127.0.0.1:8000/storage/storage/user.jpg')" />
        <h2>{{ user.name }} {{ user.surname }}</h2>
        <div class="info">
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Phone:</strong> +{{ user.country_code }} {{ user.phone_number }}</p>
            <p><strong>Country:</strong> {{ user.country_name }} ({{ user.iso_code }})</p>
            <p><strong>Role:</strong> {{ user.role }}</p>
            <RouterLink class="card-link" :to="'/users/' + user.id">  See more →</RouterLink>

        </div>
    </div>
</template>
  
<script setup>
import '../../css/card.scss'
import { defineProps } from 'vue'
import { RouterLink } from 'vue-router'

const props = defineProps()

</script>
  
