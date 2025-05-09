<template>
    <div class="card" style="margin: 1rem">
        <img :src="'http://127.0.0.1:8000/storage/' + currentUser.avatar" alt="User avatar" class="avatar" />
        <h2>{{ currentUser.name }} {{ currentUser.surname }}</h2>

        <input type="file" @change="onFileChange" accept="image/*" />
        <button @click="uploadAvatar" :disabled="!selectedFile">Upload New Avatar</button>


        <div class="info">
            <p><strong>Email:</strong> {{ currentUser.email }}</p>
            <p><strong>Phone:</strong> +{{ currentUser.country_code }} {{ currentUser.phone_number }}</p>
            <p><strong>Country:</strong> {{ currentUser.country_name }} ({{ currentUser.iso_code }})</p>
            <p><strong>Role:</strong> {{ currentUser.role }}</p>
        </div>
    </div>
</template>

<script  setup>
import '../../../css/card.scss'
import { useStore } from 'vuex'
import { computed, ref } from 'vue'

const store = useStore();

const currentUser = computed(() => store.getters.currentUser);


const selectedFile = ref(null);

function onFileChange(event) {
    const target = event.target;
    if (target.files && target.files[0]) {
        selectedFile.value = target.files[0]
    }
}

async function uploadAvatar() {
    if (!selectedFile.value) return

    const formData = new FormData()
    formData.append('avatar', selectedFile.value)

    await store.dispatch('updateCurrentUserAvatar', formData)
}


</script>
