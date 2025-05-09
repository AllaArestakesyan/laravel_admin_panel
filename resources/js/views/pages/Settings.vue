<template>
    <div class="form-container" style="flex-direction: column;gap: 50px;">

        <div>
            <VeeForm v-slot="{ handleSubmit, setFieldError, setFieldTouched }" :validation-schema="schema"
                :initial-values="currentUser" as="div">
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

        <button @click="deleteAccount" class="delete-button">
            Delete My Account
        </button>
    </div>
</template>

<script setup>
import '../../../css/form.scss'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate'
import * as yup from 'yup'

import { ref } from 'vue'

const store = useStore();
const router = useRouter();

const currentUser = store.getters.currentUser;



const schema = yup.object({
    name: yup.string().required(),
})

async function onSubmit(values, { setFieldError, setFieldTouched }) {
    console.log('Form Submitted:', values);
    try {
        const data = await store.dispatch('updateCurrentUserData', values)
        console.log("data updateCurrentUserData=>", data);
    } catch (e) {
        alert('Login failed')
    }
}


const deleteAccount = async () => {
    try {

        const data = await store.dispatch('deleteCurrentUserAccount')
        router.push('/signin')
    } catch (e) {
        console.log(e);
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