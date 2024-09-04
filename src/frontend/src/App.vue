<template>
    <v-app>
        <div class="content">
            <router-view />
        </div>
    </v-app>
</template>

<script>
export default {
    name: 'App',
}
</script>

<style>
/* Add your global styles here */
.content {
    margin-top: 50px;
    margin-bottom: 50px;
}
</style>
