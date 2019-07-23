<template>
    <div>
        <p>Keeps me wondering why</p>
        <router-link to="/user">Go to User</router-link>
    </div>
</template>

<script>
    export default {
        name: 'home',
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
