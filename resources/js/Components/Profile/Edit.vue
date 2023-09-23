<template>
    <div class="w-96 mx-auto mt-8">
        <h2 class="text-lg font-medium text-center">Edit your profile</h2>
        <form @submit.prevent="update"
            class="mt-6 flex flex-col gap-2 items-center border border-black py-8 rounded-md">
            <div class="w-64">
                <input v-model="title" type="text" placeholder="Title" class="w-64 border-2 border-black p-1 rounded">
                <p v-if="errors.title" class="text-sm text-red-500">{{ errors.title[0] }}</p>
            </div>
            <div class="w-64">
                <p>Avatar</p>
                <VueImageInput size='size-44' mimes='.png,.jpg' title="Preview (224px*224px)" ref='imageinput' v-on:change="onChangeFile"/>
                <p v-if="errors.image" class="text-sm text-red-500">{{ errors.image[0] }}</p>
            </div>
            <div class="w-64">
                <textarea v-model="description" type="text" placeholder="Description" class="w-64 h-32 border-2 border-black p-1 rounded"></textarea>
                <p v-if="errors.description" class="text-sm text-red-500">{{ errors.description[0] }}</p>
            </div>
            <div class="flex gap-1">
                <button :disabled="isDisabled" type="submit"
                    class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                    Update</button>
                <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                    <router-link :to="{ name: 'user.dashboard' }">Cancel</router-link>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import { VueImageInput } from 'vue3-picture-input';
import 'vue3-picture-input/style.css';

export default {
    name: 'Edit',

    data() {
        return {
            errors: [],
            title: '',
            description: '',
            file: null,
        }
    },

    computed: {
        isDisabled() {
            return !this.title || !this.description
        },
    },

    mounted() {
        this.getProfile()
    },

    methods: {
        onChangeFile(event) {
            this.file = this.$refs.imageinput.file
        },

        update() {
            const formData = new FormData();
            formData.append('title', this.title)
            formData.append('description', this.description)

            formData.append('_method', 'patch')

            if (this.file) {
                formData.append('image', this.file)
            }

            axios.post('/api/profiles', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(res => {
                    this.$router.push({ name: 'authUserProfile.show' })
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
        },

        getProfile() {
            axios.get('/api/profiles/show')
                .then(res => {
                    this.$refs.imageinput.imageSrc = res.data.avatar_url
                    this.title = res.data.title
                    this.description = res.data.description
                })
        }
    },

    components: {
        VueImageInput,
    }
}
</script>

<style scoped>
.w-44 {
    width: calc(12rem + 20px);
}
</style>
