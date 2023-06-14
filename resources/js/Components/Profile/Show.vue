<template>
    <div class="w-96 mx-auto mt-8 mb-8">
        <router-link :to="{ name: 'user.dashboard' }" class="text-lg text-sky-500">Back</router-link>
        <h2 class="text-lg font-medium text-center">Profile</h2>
        <div class="w-full">
            <img src="http://profiles/storage/images/80342e6dfb8a01ac93195a639f1b118f3e1f9.jpg" alt=""
                class="p-2 mx-auto w-56 h-56">
            <span class="float-right">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia debitis veritatis est, quaerat, fugit aut
                hic quos illo odio ducimus eum consectetur sint harum enim, molestiae nihil reiciendis nesciunt dolorum.
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nisi laudantium minus optio cum facilis ratione.
                Earum incidunt unde placeat iusto magnam nemo explicabo ipsum, vel minus excepturi, voluptate nisi fugit?
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque atque quia perspiciatis modi ullam rem
                voluptatum? Temporibus eligendi cumque reiciendis dolor quas, quam fuga! Velit reiciendis a maxime quasi!
                Sapiente.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus fugit qui sapiente voluptates libero, velit
                recusandae sit earum, repudiandae nostrum atque alias eos ipsa totam. Aperiam fugit quam reiciendis ipsa!
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni ut omnis esse aliquid qui voluptate atque
                saepe inventore asperiores dolores. Ipsa eius facilis necessitatibus illo dolores possimus asperiores
                laudantium totam.
            </span>
        </div>
        <button class="mt-2 font-medium border-2 border-black px-2 py-1 rounded w-32 bg-red-500/100 mt-3 hover:bg-red-500/75">Subscribe</button>
    </div>
</template>

<script>
export default {
    name: 'CurrentUserShow',
}
</script>

<style scoped></style>
