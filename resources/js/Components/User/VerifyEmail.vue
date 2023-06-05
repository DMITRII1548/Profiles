<template>
    <div class="w-96 mx-auto mt-8">
        <h1 class="text-lg font-medium text-center">Confirm your email</h1>
        <div class="border border-black rounded-md p-8">
            <div class="mt-4">
                <span class="text-normal">
                    Letter with hyperlink sent to your email address.<br>
                    If you did not get it:<br>
                    1) Check is your email correctly<br>
                    2) Check your spam folder<br>
                </span>
            </div>
            <div class="mx-auto">
                <button :disabled="isDisabled" @click="SendAgainMail" class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75 mx-auto">Send again {{ timeSendAgain }} {{ seconds }} seconds</button>
                <p v-if="error" class="text-sm text-red-500">{{ error }}</p>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'VerifyEmail',

    data() {
        return {
            timeSendAgain: 60,
            error: ''
        }
    },

    methods: {
        SendAgainMail() {
            axios.post('/email/verification-notification')
                .then(res => {
                    this.timeSendAgain = 60
                })
                .catch(error => {
                    this.error = "We can't verify your email"
                    this.timeSendAgain = 60
                })
        }
    },

    computed: {
        seconds() {
            if (this.timeSendAgain > 0) {
                setTimeout(() => {
                    this.timeSendAgain--
                    return this.timeSendAgain
                }, 1000)
            }
        },

        isDisabled() {
            return this.timeSendAgain
        }
    },
}
</script>

<style scoped>

</style>
