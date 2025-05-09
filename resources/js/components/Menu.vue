<template>
  <nav class="main-menu" >
    <ul>
      <li v-for="item in filteredMenu" :key="item.path">
        <!-- <a :href="item.href">{{ item.text }}</a> -->
        <router-link :to="item.path">{{ item.label }}</router-link>
      </li>
      <li>
        <button class="logout-btn"  @click='logout()'>Log Out</button>
      </li>
    </ul>
  </nav>
</template>

<script setup >
import '../../css/menu.scss'
import { computed } from 'vue';
import { useStore } from 'vuex';
import { menuItems } from "../constants/menus.js";
import { useRouter } from 'vue-router'

const store = useStore();

const currentUser = store.getters["currentUser"]
const userRole = currentUser.role || 'user';

const filteredMenu = computed(() =>
  menuItems.filter(item => item.roles.includes(userRole))
);


const router = useRouter();
async function logout() {
  try {
    await store.dispatch('logout')
    router.push('/signin')
  } catch (e) {
    alert('Login failed')
  }
}
</script>

