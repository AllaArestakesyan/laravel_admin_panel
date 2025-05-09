<template>
  <div class="card" style="margin: 1rem">
    <img
      :src="currentUser.avatar ? '/storage/' + currentUser.avatar : '/storage/uploads/user.png'"
      alt="User avatar"
      class="avatar"
    />
    <h2>{{ currentUser.name }} {{ currentUser.surname }}</h2>

    <div>
      <input type="file" @change="onFileChange" accept="image/*" />
      <button @click="uploadAvatar" :disabled="!selectedFile">Upload New Avatar</button>
    </div>

    <div class="info">
      <p><strong>Email:</strong> {{ currentUser.email }}</p>
    </div>
  </div>
</template>

<script>
import '../../../css/card.scss'

export default {
  name: 'ProfileCard',
  data() {
    return {
      selectedFile: null
    }
  },
  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    }
  },
  methods: {
    onFileChange(event) {
      const file = event.target.files && event.target.files[0]
      if (file) {
        this.selectedFile = file
      }
    },
    async uploadAvatar() {
      if (!this.selectedFile) return

      const formData = new FormData()
      formData.append('avatar', this.selectedFile)

      await this.$store.dispatch('updateCurrentUserAvatar', formData)
    }
  }
}
</script>
