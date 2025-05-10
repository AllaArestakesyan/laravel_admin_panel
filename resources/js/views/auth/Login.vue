<template>
  <div class="form-container">
    <div>
      <VeeForm v-slot="{ handleSubmit, setFieldError, setFieldTouched }" :validation-schema="schema" as="div">
        <form @submit="handleSubmit($event, onSubmit)">
          <h2>{{ $t("login.login") }}</h2>

          <div class="form-group">
            <label for="email">{{ $t("login.email") }}</label>
            <Field name="email" />
            <ErrorMessage class="error" name="email" />
          </div>

          <div class="form-group">
            <label for="password">{{ $t("login.password") }}</label>
            <Field name="password" type="password" />
            <ErrorMessage class="error" name="password" />
          </div>

          <button type="submit">{{ $t("login.login") }}</button>
        </form>
      </VeeForm>
      <router-link to="/register"> >> {{ $t("login.register") }}</router-link>
    </div>
      <div class="language">
          <select v-model="selectedLanguage" @change="changeLanguage" style="margin-left: 10px;">
              <option v-for="lang in languages" :key="lang.code" :value="lang.code">
                  {{ lang.flag }}
              </option>
          </select>
      </div>
  </div>
</template>

<script>
import '../../../css/form.scss'
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import * as yup from 'yup'
import {languageOptions} from "@/constants/languageOptions.js";

export default {
  name: 'SignInForm',
  components: {
    VeeForm,
    Field,
    ErrorMessage,
  },
  data() {
    return {
        languages: languageOptions,
        selectedLanguage: this.$i18n.locale,
      schema: yup.object({
        email: yup.string().email().required(),
        password: yup.string().min(6).required(),
      }),
    }
  },
  computed: {
    done() {
      return this.$store.getters.done
    }
  },
  methods: {
    async onSubmit(values, { setFieldError, setFieldTouched }) {
      try {
        await this.$store.dispatch('login', {
          email: values.email,
          password: values.password
        })
        if (this.done) {
          this.$router.push('/profile')
        } else {
          setFieldTouched('email', true);
          setFieldError('email', "Email or password incorrect");
        }
      } catch (e) {
        console.error(e)
        alert('Login failed')
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
    top: 50px;
    width: 80px;
    padding: 10px;
}
</style>
