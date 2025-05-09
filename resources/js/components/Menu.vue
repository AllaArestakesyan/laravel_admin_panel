<template>
  <nav class="main-menu">
    <ul>
      <li v-for="item in filteredMenu" :key="item.path">
        <router-link :to="item.path">{{ item.label }}</router-link>
      </li>
      <li>
        <button class="logout-btn" @click="logout">Log Out</button>
      </li>
    </ul>
  </nav>
</template>

<script>
import '../../css/menu.scss'
import { menuItems } from '../constants/menus.js'

export default {
  name: 'MainMenu',

  computed: {
    currentUser() {
      return this.$store.getters['currentUser']
    },
    filteredMenu() {
      return menuItems.filter(item => item.roles.includes("user"))
    }
  },

  methods: {
    async logout() {
      try {
        await this.$store.dispatch('logout')
        this.$router.push('/login')
      } catch (e) {
        alert('Logout failed')
      }
    }
  }
}
</script>
