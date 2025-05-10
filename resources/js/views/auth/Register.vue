<template>
  <div class="form-container">
    <div>
      <VeeForm
        v-slot="{ handleSubmit, setFieldError, setFieldTouched }"
        :validation-schema="schema"
        as="div"
      >
        <form @submit="handleSubmit($event, (values) => onSubmit(values, { setFieldError, setFieldTouched }))">
          <h2>{{ $t("login.register") }}</h2>

          <div class="form-group">
            <label for="name">{{ $t("login.name") }}</label>
            <Field name="name" />
            <ErrorMessage class="error" name="name" />
          </div>

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

          <div class="form-group">
            <label for="confirm_password">{{ $t("login.confirm_password") }}</label>
            <Field name="confirm_password" type="password" />
            <ErrorMessage class="error" name="confirm_password" />
          </div>

          <button type="submit">{{ $t("login.register") }}</button>
        </form>
      </VeeForm>
      <router-link to="/login"> >> {{ $t("login.login") }}</router-link>
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
  name: 'SignUpForm',
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
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().min(6).required(),
        confirm_password: yup
          .string()
          .oneOf([yup.ref('password')], 'Passwords must match')
          .required(),
      }),
    }
  },
  methods: {
    async onSubmit(values, { setFieldError, setFieldTouched }) {
      try {
        const data = await this.$store.dispatch('register', values)
        if (data && data.errors && data.errors.email) {
          setFieldTouched('email', true)
          setFieldError('email', data.errors.email[0])
        } else {
          this.$router.push('/login')
        }
      } catch (e) {
        alert('Registration failed')
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
