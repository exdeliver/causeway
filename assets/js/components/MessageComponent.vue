<template>
    <div class="alert spacing" role="alert" v-bind:class="flashMessage.type" v-show="flashMessage.show">
        <strong>{{ flashMessage.title }}</strong><br/>
        <span v-html="flashMessage.message">{{ flashMessage.message }}</span>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Message mounted.');
        },
        created() {
            let vm = this;
            EventBus.$on('status-message', obj => {
                this.flash(obj.type, obj.title, obj.message, true);
            });
        },
        data: function () {
            return {
                flashMessage: {
                    type: '',
                    title: '',
                    message: '',
                    show: false,
                },
            };
        },

        methods: {
            flash(type, title, message) {
                this.flashMessage.show = true;
                this.flashMessage.type = type;
                this.flashMessage.title = title;
                this.flashMessage.message = message;
            },
            hide() {
                this.flashMessage.show = false;
            },
        }
    };
</script>
