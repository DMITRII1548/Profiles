<template>
    	<div class="w-96 mx-auto mt-8">
    		<h1 class="text-lg font-medium text-center">Login</h1>
    		<form @submit.prevent="login" class="mt-6 flex flex-col gap-2 items-center border border-black py-8 rounded-md">
                <div class="w-64">
                    <input v-model="email" type="email" placeholder="Email" class="w-full border-2 border-black p-1 rounded">
                    <p v-if="errors.email" class="text-sm text-red-500">{{ errors.email[0] }}</p>
                </div>
                <div class="w-64">
                    <input v-model="password" type="password" placeholder="Password" class="w-full border-2 border-black p-1 rounded">
                    <p v-if="errors.password" class="text-sm text-red-500">{{ errors.password[0] }}</p>
                </div>
    			<div class="flex gap-1">
    				<button :disabled="isDisabled" type="submit" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">Sign in</button>
    			    <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                        <router-link :to="{ name: 'user.registration' }">Sing up</router-link>
                    </button>
                </div>
    		</form>
    		<router-link :to="{ name: 'user.forgot-password' }" class="text-center"><div class="underline mt-6">Forgot password?</div></router-link>
    	</div>
</template>

<script>
export default {
    name: 'Registration',

    data() {
        return {
            email: '',
            password: '',
            errors: [],
        }
    },

    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                    email: this.email,
                    password: this.password,
                })
                    .then(res => {
                        localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                        this.$router.push({ name: 'user.dashboard' })
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            });

        }
    },

    computed: {
        isDisabled() {
            return !this.email || !this.password
        }
    }
}
</script>

<style scoped></style>
