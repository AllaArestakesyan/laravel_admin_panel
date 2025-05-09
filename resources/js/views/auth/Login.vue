<template>
    <div class="form-container">
      <div>
        <VeeForm v-slot="{ handleSubmit }" :validation-schema="schema" as="div">
          <form @submit="handleSubmit($event, onSubmit)">
            <h2>Sign In</h2>
  
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
  
            <button type="submit">
              Sign In
            </button>
          </form>
        </VeeForm>
        <RouterLink to="/register"> >> Register</RouterLink>
      </div>
    </div>
  </template>
  
  <script  setup>
  import '../../../css/form.scss'
  import { RouterLink } from 'vue-router'
  import { useStore } from 'vuex'
  import { useRouter } from 'vue-router'
  import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
  import * as yup from 'yup'
  
  
  const store = useStore();
  const router = useRouter();
  
  const schema = yup.object({
    email: yup.string().email().required(),
    password: yup.string().min(6).required(),
  })
  
  async function onSubmit(values) {
  
    try {
      await store.dispatch('login', { email: values.email, password: values.password })
      router.push('/profile')
  
    } catch (e) {
      console.log(e);
  
      alert('Login failed')
    }
  }
  
  </script>
  