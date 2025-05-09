<template>
  <div class="form-container">
    <div>
      <VeeForm
        v-slot="{ handleSubmit, setFieldError, setFieldTouched }"
        :validation-schema="schema"
        as="div"
      >
        <form @submit="handleSubmit($event, (values) => onSubmit(values, { setFieldError, setFieldTouched }))">
          <h2>Sign Up</h2>

          <div class="form-group">
            <label for="name">Name</label>
            <Field name="name" />
            <ErrorMessage class="error" name="name" />
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <Field name="email" />
            <ErrorMessage class="error" name="email" />
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <Field name="password" type="password" />
            <ErrorMessage class="error" name="password" />
          </div>

          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <Field name="confirm_password" type="password" />
            <ErrorMessage class="error" name="confirm_password" />
          </div>

          <button type="submit">Sign Up</button>
        </form>
      </VeeForm>
      <router-link to="/login"> >> Log In</router-link>
    </div>
  </div>
</template>

<script>
import '../../../css/form.scss'
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import * as yup from 'yup'

export default {
  name: 'SignUpForm',
  components: {
    VeeForm,
    Field,
    ErrorMessage,
  },
  data() {
    return {
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
    }
  }
}
</script>
