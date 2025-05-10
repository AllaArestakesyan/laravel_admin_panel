<template>
  <nav class="main-menu">
    <ul>
      <li v-for="item in filteredMenu" :key="item.path">
        <router-link :to="item.path">
          {{ $t(`menu.${item.label}`) }}
        </router-link>
      </li>
      <li>
        <button class="logout-btn" @click="logout">{{ $t("menu.Logout") }}</button>
      </li>
    </ul>

    <div class="language">
      <select v-model="selectedLanguage" @change="changeLanguage" style="margin-left: 10px;">
        <option v-for="lang in languages" :key="lang.code" :value="lang.code">
          {{ lang.flag }}
        </option>
      </select>
    </div>
  </nav>
</template>

<script>
import '../../css/menu.scss'
import { menuItems } from '../constants/menus.js'
import { languageOptions } from '../constants/languageOptions.js'

export default {
  name: 'MainMenu',
  data() {
    return {
      menuItems,
      languages: languageOptions,
      selectedLanguage: this.$i18n.locale

    }
  },
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
        await this.$store.dispatch('logout');
        this.$router.push('/login');
      } catch (e) {
        alert('Logout failed');
      }
    },
    changeLanguage(code) {
      this.$i18n.locale = this.selectedLanguage
      localStorage.setItem('locale', this.selectedLanguage)
    }
  }
}
</script>

<style scoped lang="scss">
.language{
  position: absolute;
  right: 20px;
}
</style>