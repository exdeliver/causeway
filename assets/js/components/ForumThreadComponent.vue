<template>

</template>

<script>
    import Message from './MessageComponent.vue';

    export default {
        mounted() {
            console.log('Forum index mounted.');
        },
        props: ['category'],
        components: {
            Message
        },
        data: function () {
            return {
                loginDetails: {
                    email: '',
                    password: ''
                },
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message)
            }
        },
        methods: {}
    }
</script>
