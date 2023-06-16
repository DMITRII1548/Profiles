<template>
    <div class="w-96 mx-auto mt-8 mb-8">
        <router-link :to="{ name: 'user.dashboard' }" class="text-lg text-sky-500">Back</router-link>
        <h2 class="text-lg font-medium text-center">Your profile</h2>
        <div class="w-full">
            <img src="http://profiles/storage/images/9cfb1fe4135ab27687be2314bd013c35.png" alt="" class="p-2 mx-auto w-56 h-56">
            <span class="float-right">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia debitis veritatis est, quaerat, fugit aut hic quos illo odio ducimus eum consectetur sint harum enim, molestiae nihil reiciendis nesciunt dolorum.
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi laudantium minus optio cum facilis ratione. Earum incidunt unde placeat iusto magnam nemo explicabo ipsum, vel minus excepturi, voluptate nisi fugit?
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque atque quia perspiciatis modi ullam rem voluptatum? Temporibus eligendi cumque reiciendis dolor quas, quam fuga! Velit reiciendis a maxime quasi! Sapiente.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus fugit qui sapiente voluptates libero, velit recusandae sit earum, repudiandae nostrum atque alias eos ipsa totam. Aperiam fugit quam reiciendis ipsa!
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni ut omnis esse aliquid qui voluptate atque saepe inventore asperiores dolores. Ipsa eius facilis necessitatibus illo dolores possimus asperiores laudantium totam.
            </span>
        </div>
        <div class="flex gap-2 w-full">
            <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-sky-500/100 mt-3 hover:bg-sky-500/75">
                <router-link :to="{ name: 'profile.edit' }">Edit</router-link>
            </button>
            <button class="font-medium border-2 border-black px-2 py-1 rounded w-32 bg-red-500/100 mt-3 hover:bg-red-500/75">
                Delete
            </button>
        </div>

    </div>
</template>

<script>
export default {
    name: 'CurrentUserShow',
}
</script>

<style scoped>

</style>
