import store from '../../store'
import router from '../index';

export async function authMiddleware(to, next) {
  try {

    await store.dispatch('profile')

    if (store.getters.isAuthenticated) {
      next()
    } else {
      next('/login');
    }
  } catch (e) {
    next('/login');
  }
}
