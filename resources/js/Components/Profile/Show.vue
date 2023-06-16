<template>
    <div class="w-96 mx-auto mt-8 mb-8">
        <template v-if="profile">
            <router-link :to="{ name: 'user.dashboard' }" class="text-lg text-sky-500">Back</router-link>
            <h2 class="text-lg font-medium text-center">{{ profile.title }}</h2>
            <div class="w-full">
                <img :src="profile.avatar_url" alt=""
                    class="p-2 mx-auto w-56 h-56">
                <span class="float-left">
                    {{ profile.description }}
                </span>
            </div>
            <div class="w-full flex">
                <button class="mt-2 font-medium border-2 border-black px-2 py-1 rounded w-32 bg-red-500/100 mt-3 hover:bg-red-500/75">Subscribe</button>
            </div>
        </template>
        <template v-if="!profile">
            <h2 class="text-lg font-medium text-center">Profile doesn't exist</h2>
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
            axios.get(`/api/profiles/${this.$route.params.id}`)
                .then(res => {
                    this.profile = res.data
                })
                .catch(res => {
                    this.profile = null
                })
        },
    }
}
</script>

<style scoped></style>
