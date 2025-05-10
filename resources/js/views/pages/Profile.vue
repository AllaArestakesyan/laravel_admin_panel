<template>
  <div class="profile">
    <div class="card" style="margin: 1rem">
      <img :src="currentUser.avatar ? '/storage/' + currentUser.avatar : '/storage/uploads/user.png'" alt="User avatar"
        class="avatar" />
      <h2>{{ currentUser.name }} {{ currentUser.surname }}</h2>

      <div>
        <input type="file" @change="onFileChange" accept="image/*" />
        <button @click="uploadAvatar" :disabled="!selectedFile">{{ $t("profile.uploadAvatar") }}</button>
      </div>

      <div class="info">
        <p><strong>{{ $t("profile.email") }}:</strong> {{ currentUser.email }}</p>
      </div>
    </div>
    <div class="slider">
      <div class="slide" v-for="(item, index) in jobs" :key="item.id" :class="{ active: index === currentIndex }">
        <h2>{{ item.title }}</h2>
        <p>{{ item.description }}</p>
        <p><strong>Budget:</strong> ${{ item.budget }}</p>
        <p><em>Last updated:</em> {{ formatDate(item.updated_at) }}</p>
      </div>

      <div class="controls">
        <button @click="prev">‹</button>
        <button @click="next">›</button>
      </div>
    </div>

  </div>
</template>

<script>
import '../../../css/card.scss'
import '../../../css/slider.scss'

export default {
  name: 'ProfileCard',
  data() {
    return {
      selectedFile: null,
      jobs: [],
      currentIndex:1

    }
  },
  async created() {
    try {
      await this.$store.dispatch("getJobs");
      this.jobs = this.$store.getters['jobs']
      console.log(this.jobs);

    } catch (error) {
      console.error("Failed to load jobs", error);
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
    },
    next() {
      this.currentIndex = (this.currentIndex + 1) % this.jobs.length;
    },
    prev() {
      this.currentIndex =
        (this.currentIndex - 1 + this.jobs.length) % this.jobs.length;
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    }
  }
}
</script>
<style scoped lang="scss">
.profile{
  display: grid;
  grid-template-columns: 1fr 2fr;
}
</style>