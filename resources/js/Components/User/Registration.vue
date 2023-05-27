<template>
    <div class="w-96 mx-auto mt-8">
        <h1 class="text-lg font-medium text-center">Registration</h1>
        <form @submit.prevent="register" class="mt-6 flex flex-col gap-2 items-center border border-black py-8 rounded-md">
            <div class="w-64">
                <input v-model="name" type="text" placeholder="Name" class="w-full border-2 border-black p-1 rounded">
                <p v-if="errors.name" class="text-sm text-red-500">{{ errors.name[0] }}</p>
            </div>
            <div class="w-64">
                <input v-model="email" type="email" placeholder="Email" class="w-full border-2 border-black p-1 rounded">
                <p v-if="errors.email" class="text-sm text-red-500">{{ errors.email[0] }}</p>
            </div>
            <div class="w-64">
                <input v-model="password" type="password" placeholder="Password" class="w-full border-2 border-black p-1 rounded">
                <p v-if="errors.password" class="text-sm text-red-500">{{ errors.password[0] }}</p>
            </div>
            <div class="w-64">
                <input v-model="password_confirmation" type="password" placeholder="Confirm password" class="w-full border-2 border-black p-1 rounded">
                <p v-if="errors.password_confirmation" class="text-sm text-red-500">{{ errors.password_confirmation[0] }}</p>
            </div>
            <div>
                <button :disabled="isDisabled" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">Sign up</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'Registration',

    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: [],
        }
    },

    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                    .then(res => {
                        localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                    })   
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })             
            });

        }
    },

    computed: {
        isDisabled() {
            return !this.name || !this.email || !this.password || !this.password_confirmation
        }
    }
}
</script>

<style scoped>

</style>
