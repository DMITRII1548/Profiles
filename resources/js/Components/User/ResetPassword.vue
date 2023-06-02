<template>
    <div class="w-96 mx-auto mt-8">
        <h1 class="text-lg font-medium text-center">Reset password</h1>
        <form @submit.prevent="resetPassword" class="mt-6 flex flex-col gap-2 items-center border border-black py-8 rounded-md">
            <div>
                <input v-model="email" type="email" placeholder="Email" class="w-64 border-2 border-black p-1 rounded">
            </div>
            <div>
                <input v-model="password" type="password" placeholder="Password" class="w-64 border-2 border-black p-1 rounded">
            </div>
            <div>
                <input v-model="password_confirmation" type="password" placeholder="Confirm password" class="w-64 border-2 border-black p-1 rounded">
                <p v-if="error" class="text-sm text-red-500">{{ error }}</p>
            </div>
            <div>
                <button :disabled="isDisabled" type="submit" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">Reset password</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'ResetPassword',

    data() {
        return {
            email: '',
            password: '',
            password_confirmation: '',
            errors: '',
        }
    },

    methods: {
        resetPassword() {
            axios.post('/reset-password', {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                token: this.$route.params.token
            })
                .then(res => {
                    this.$router.push({ name: 'user.login' })
                })
                .catch(error => {
                    this.error = 'Inputed data is not correct'
                })
        }
    },

    computed: {
        isDisabled() {
            return !this.email || !this.password || !this.password_confirmation
        }
    },
}
</script>

<style scoped>

</style>
