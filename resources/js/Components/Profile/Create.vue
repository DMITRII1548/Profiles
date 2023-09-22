<template>
    <div class="w-96 mx-auto mt-8">
        <h2 class="text-lg font-medium text-center">Create your profile</h2>
        <form @submit.prevent="store"
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
                    Create</button>
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
    name: 'Create',

    data() {
        return {
            errors: [],
            title: '',
            description: '',
            file: {},
        }
    },

    computed: {
        isDisabled() {
            return !this.title || !this.description || !this.file
        },
    },

    methods: {
        onChangeFile(event) {
            this.file = this.$refs.imageinput.file
        },

        store() {
            axios.post('/api/profiles', {
                title: this.title,
                description: this.description,
                image: this.file,
            }, {
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
