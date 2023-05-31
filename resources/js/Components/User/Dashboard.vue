<template>
    <div class="w-96 mx-auto mt-8">
        <h2 class="text-lg font-medium text-center">You loginned as {{ user.name }}</h2>
        <div class="flex flex-col gap-2 items-center">
            <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                Home
            </button>
            <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                Account
            </button>
            <button @click="logout()" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                Logout
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Dashboard',

    data() {
        return {
            user: '',
        }
    },

    mounted() {
        this.getUser()
    },

    methods: {
        getUser() {
            axios.get('/api/user')
                .then(res => {
                    this.user = res.data
                })
        },

        logout() {
            axios.post('/logout')
                .then(res => {
                    localStorage.removeItem('x_xsrf_token')
                    this.$router.push({ name: 'user.login' })
                })
        }
    }
}
</script>

<style scoped>

</style>
