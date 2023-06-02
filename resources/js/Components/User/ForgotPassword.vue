<template>
    <div class="w-96 mx-auto mt-8">
        <h1 class="text-lg font-medium text-center">Forgot password</h1>
        <form @submit.prevent="forgotPassword" class="mt-6 flex flex-col gap-2 items-center border border-black py-8 rounded-md">
            <div>
                <input v-model="email" type="email" placeholder="Email" class="w-64 border-2 border-black p-1 rounded">
                <p v-if="message" class="text-sm text-green-500">{{ message }}</p>
                <p v-if="error" class="text-sm text-red-500">{{ error }}</p>
            </div>
            <div>
                <button :disabled="isDisabled" type="submit" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">Next</button>
            </div>
        </form>
        <router-link :to="{ name: 'user.login' }" class="text-left"><div class="underline mt-6">Cancel</div></router-link>
    </div>
</template>

<script>
export default {
    name: 'ForgotPassword',

    data() {
        return {
            email: '',
            message: '',
            error: '',
        }
    },

    methods: {
        forgotPassword() {
            this.message = ''
            this.error = ''

            axios.post('/forgot-password', {
                email: this.email,
            })
                .then(res => {
                    this.message = res.data.message
                })
                .catch(error => {
                    this.error = 'Check is correct your email and try again'
                })
        }
    },

    computed: {
        isDisabled() {
            return !this.email
        }
    }
}
</script>

<style scoped>

</style>
