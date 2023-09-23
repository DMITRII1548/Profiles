<template>
    <div class="w-96 mx-auto mt-8 mb-8">
        <template v-if="profile">
            <router-link :to="{ name: 'user.dashboard' }" class="text-lg text-sky-500">Back</router-link>
            <h2 class="text-lg font-medium text-center">{{ profile.title }}</h2>
            <div class="w-full">
                <img :src="profile.avatar_url" alt="" class="p-2 mx-auto w-56 h-56">
                <span class="float-left">
                    {{ profile.description }}
                </span>
            </div>
            <div class="flex gap-2 w-full">
                <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                    <router-link :to="{ name: 'profile.edit' }">Edit</router-link>
                </button>
                <button @click="destroy" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-red-500/100 mt-3 hover:bg-red-500/75">
                    Delete
                </button>
            </div>
        </template>
        <template v-if="!profile">
            <div class="flex flex-col justify-center items-center">
                <h2 class="text-lg font-medium text-center">Your profile doesn't exist</h2>
                <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                    <router-link :to="{ name: 'profile.create' }">Create</router-link>
                </button>
            </div>

        </template>
    </div>
</template>

<script>
export default {
    name: 'CurrentUserShow',

    data() {
        return {
            profile: [],
        }
    },

    mounted() {
        this.getProfile()
    },

    methods: {
        getProfile() {
            axios.get('/api/profiles/show')
                .then(res => {
                    this.profile = res.data
                })
                .catch(res => {
                    this.profile = null
                })
        },

        destroy() {
            axios.delete('/api/profiles')
                .then(res => {
                    this.$router.push({ name: 'user.dashboard' })
                })
        },
    }
}
</script>

<style scoped>

</style>
