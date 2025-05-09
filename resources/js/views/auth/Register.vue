<template>
    <div class="form-container">
        <div>
            <VeeForm v-slot="{ handleSubmit, setFieldError, setFieldTouched }" :validation-schema="schema" as="div">
                <form @submit="handleSubmit($event, onSubmit)">
                    <h2>Sign Up</h2>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <Field name="name" />
                        <ErrorMessage class="error" name="name" />
                    </div>


                    <div class="form-group">
                        <label for="email">Email</label>
                        <Field name="email" />
                        <ErrorMessage class="error">{{ message }} </ErrorMessage>
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

                    <button type="submit">
                        Sign Up
                    </button>

                </form>
            </VeeForm>
            <RouterLink to="/login"> >> Loo In</RouterLink>
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
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().min(6).required(),
    confirm_password: yup
        .string()
        .oneOf([yup.ref('password')], 'Passwords must match')
        .required(),
})

async function onSubmit(values, { setFieldError, setFieldTouched }) {
    try {
        const data = await store.dispatch('register', values)
        console.log("data register=>", data);
        if ("errors" in data) {
            console.log(data.errors.email[0]);
            setFieldTouched('email', true);
            setFieldError('email', data.errors.email[0]);

        } else {
            router.push("/login")
        }
    } catch (e) {
        alert('Login failed')
    }
}
</script>
