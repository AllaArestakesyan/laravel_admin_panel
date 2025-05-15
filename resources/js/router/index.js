import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import DashboardLayout from '../views/layouts/DashboardLayout.vue'
import Profile from '../views/pages/Profile.vue'
import Jobs from '../views/pages/Jobs.vue'
import Job from '../views/pages/Job.vue'
import Skills from '../views/pages/Skills.vue'
import Skill from '../views/pages/Skill.vue'
import Users from '../views/pages/Users.vue'
import User from '../views/pages/User.vue'
import Countries from '../views/pages/Countries.vue'
import Settings from '../views/pages/Settings.vue'
import NotFound from '../views/pages/NotFound.vue'
import { authMiddleware } from './middleware/auth'


const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  {
    path: '/',
    component: DashboardLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/login',
      },
      {
        path: 'profile',
        name: 'profile',
        component: Profile,
      },
      {
        path: 'skills',
        name: 'skills',
        component: Skills,
      },
      {
        path: 'skills/:id',
        name: 'skill',
        component: Skill,
      },
      {
        path: 'users',
        name: 'users',
        component: Users,
      },
      {
        path: 'users/:id',
        name: 'user',
        component: User,
      },
      {
        path: 'jobs',
        name: 'jobs',
        component: Jobs,
      },
      {
        path: 'jobs/:id',
        name: 'job',
        component: Job,
      },
      {
        path: 'countries',
        name: 'country',
        component: Countries,
      },
      {
        path: 'settings',
        name: 'settings',
        component: Settings,
      },
    ],
  },
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound }

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(async (to, _, next) => {
  if (to.meta.requiresAuth) {
    await authMiddleware(to, next)

  } else {
    next()
  }
})

export default router
