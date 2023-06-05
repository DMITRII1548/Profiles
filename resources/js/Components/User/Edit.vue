<template>
    <div class="w-96 mx-auto mt-8">
        <h1 class="text-lg font-medium text-center">Edit your profile</h1>
        <form @submit.prevent="updateAccount"
            class="mt-6 flex flex-col gap-2 items-center border border-black py-8 rounded-md">
            <div class="w-64">
                <input v-model="name" type="name" placeholder="name" class="w-64 border-2 border-black p-1 rounded">
                <p v-if="errors.name" class="text-sm text-red-500">{{ errors.name[0] }}</p>
            </div>
            <div class="w-64">
                <input v-model="password" type="password" placeholder="Password"
                    class="w-64 border-2 border-black p-1 rounded">
                <p v-if="errors.password" class="text-sm text-red-500">{{ errors.password[0] }}</p>
            </div>
            <div class="w-64">
                <input v-model="password_confirmation" type="password" placeholder="Confirm password"
                    class="w-64 border-2 border-black p-1 rounded">
                <p v-if="errors.password_confirmation" class="text-sm text-red-500">{{ errors.password_confirmation[0] }}</p>
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
export default {
    name: 'Edit',

    data() {
        return {
            name: '',
            password: '',
            password_confirmation: '',
            errors: [],
        }
    },

    mounted() {
        this.getCurrentUser()
    },

    methods: {
        updateAccount() {
            axios.patch('/api/user', {
                name: this.name,
                password: this.password,
                password_confirmation: this.password_confirmation,
            })
                .then(res => {
                    this.$router.push({ name: 'user.dashboard' })
                })
                .catch(error => {
                    console.log(error)
                    this.errors = error.response.data.errors
                })
        },

        getCurrentUser() {
            axios.get('/api/user')
                .then(res => {
                    this.name = res.data.name
                })
        },
    },

    computed: {
        isDisabled() {
            return !this.name || !this.password || !this.password_confirmation
        }
    },
}
</script>

<style scoped></style>
