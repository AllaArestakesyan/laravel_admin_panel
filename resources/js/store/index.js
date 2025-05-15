import { createStore } from 'vuex';
import auth from './modules/auth';
import user from './modules/user';
import skills from './modules/skills';
import job from './modules/job';
import country from './modules/country';

const store = createStore({
  modules: {
    auth,
    user,
    skills,
    job,
    country
  },
});

export default store;