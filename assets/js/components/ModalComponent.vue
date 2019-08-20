<template>
    <div class="flex items-center justify-center" v-show="modalMessage.show">
        <div @click="toggleModal" class="modal-overlay absolute w-full h-full bg-black opacity-25 top-0 left-0 cursor-pointer"></div>
        <div class="absolute w-1/2 h-32 bg-white rounded-sm shadow-lg flex items-center justify-center" v-bind:class="modalMessage.type">
            <p>
                <span class="text-2xl">
                    {{ modalMessage.title }}
                </span>
                <br/><br/>
                <span v-html="modalMessage.message">{{ modalMessage.message }}</span>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Modal mounted.');
        },
        created() {
            let vm = this;

            EventBus.$on('modal-message', obj => {
                vm.flash(obj.type, obj.title, obj.message);
            });

        },
        data: function () {
            return {
                modalMessage: {
                    type: '',
                    title: '',
                    message: '',
                    show: false,
                },
            };
        },

        methods: {
            toggleModal() {
                this.modalMessage.show = !this.modalMessage.show;
            },
            flash(type, title, message) {
                this.modalMessage.show = true;
                this.modalMessage.type = type;
                this.modalMessage.title = title;
                this.modalMessage.message = message;
            },
        }
    };
</script>
