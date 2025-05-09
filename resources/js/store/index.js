import { createStore } from 'vuex';
import auth from './modules/auth';
import user from './modules/user';
import skills from './modules/skills';
import job from './modules/job';

const store = createStore({
  modules: {
    auth,
    user,
    skills,
    job
  },
});

export default store;