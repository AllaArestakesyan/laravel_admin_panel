<template>
  <div class="card">
    <img
      :src="'/storage/' + user.avatar"
      alt="User avatar"
      class="avatar"
      @error="onImageError"
    />
    <h2>{{ user.name }} {{ user.surname }}</h2>
    <div class="info">
      <p><strong>Email:</strong> {{ user.email }}</p>
      <router-link class="card-link" :to="'/users/' + user.id">See more →</router-link>
    </div>
  </div>
</template>

<script>
import '../../css/card.scss'

export default {
  name: 'UserCard',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  methods: {
    onImageError(e) {
      e.target.src = '/storage/storage/user.jpg';
    }
  }
}
</script>
