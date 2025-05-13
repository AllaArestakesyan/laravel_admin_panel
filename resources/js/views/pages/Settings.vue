<template>
    <div class="form-container" style="flex-direction: column;gap: 50px;">

        <div>
            <VeeForm v-slot="{ handleSubmit }" :validation-schema="schema" :initial-values="currentUser" as="div">
                <form @submit="handleSubmit($event, onSubmit)">
                    <h2>Update User</h2>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <Field name="name" />
                        <ErrorMessage style="color: #900;font-weight:600" name="name" />
                    </div>

                    <button type="submit">
                        Update data
                    </button>

                </form>
            </VeeForm>
        </div>
        <div>
            <VeeForm v-slot="{ handleSubmit }" :validation-schema="schemaPassword" as="div">
                <form @submit="handleSubmit($event, onSubmitPassword)">
                    <h2>Update Password</h2>

                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <Field  type="password" name="old_password" />
                        <ErrorMessage style="color: #900;font-weight:600" name="old_password" />
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <Field  type="password" name="password" />
                        <ErrorMessage style="color: #900;font-weight:600" name="password" />
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <Field  type="password" name="confirm_password" />
                        <ErrorMessage style="color: #900;font-weight:600" name="confirm_password" />
                    </div>

                    <button type="submit">
                        Update password
                    </button>

                </form>
            </VeeForm>
        </div>

        <button @click="deleteAccount" class="delete-button">
            Delete My Account
        </button>
    </div>
</template>

<script>
import '../../../css/form.scss'
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import * as yup from 'yup'

export default {
    name: 'Settings',
    components: {
        VeeForm,
        Field,
        ErrorMessage,
    },
    data() {
        return {
            schema: yup.object({
                name: yup.string().required(),
            }),
            schemaPassword: yup.object({
                old_password: yup.string().min(6).required(),
                password: yup.string().min(6).required(),
                password: yup.string().min(6).required(),
                confirm_password: yup
                    .string()
                    .oneOf([yup.ref('password')], 'Passwords must match')
                    .required(),
            }),
        }
    },
    computed: {
        currentUser() {
            return this.$store.getters.currentUser
        }
    },
    methods: {
        async onSubmit(values) {
            try {
                const data = await this.$store.dispatch('updateCurrentUserData', { name: values.name })
                alert('Update success!')
            } catch (e) {
                alert('Login failed')
            }
        },
        async onSubmitPassword(values) {
            try {
                const data = await this.$store.dispatch('updateCurrentUserPasswordData', values)
                console.log(data);
                if(data.message){
                    
                    alert('Login failed')
                }else{

                    alert('Update password success!')
                }
            } catch (e) {
                alert('Login failed')
            }
        },
        async deleteAccount() {
            try {
                const data = await this.$store.dispatch('deleteCurrentUserAccount')
                router.push('/login')
            } catch (e) {
                console.log(e);
            }
        }
    }
}


</script>
<style scoped>
.delete-button {
    padding: 0.75rem 1.5rem;
    background: #d32f2f;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease;
}

.delete-button:hover {
    background: #b71c1c;
}
</style>