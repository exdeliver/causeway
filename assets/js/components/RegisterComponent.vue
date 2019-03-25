<template>
    <form :action="register_route" id="register-form" method="POST" v-on:submit="registerPost">
        <input :value="csrf_token" name="_token" type="hidden"/>
        <message ref="formMessage"></message>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="name">Name</label>

            <div class="col-md-6">
                <input autofocus class="form-control" id="name" name="name" type="text" v-model="registerDetails.name">
                <span class="help-block text-danger" v-if="formErrors.name">{{ formErrors.name[0] }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="email">E-mail address</label>

            <div class="col-md-6">
                <input class="form-control" id="email" name="email" type="email" v-model="registerDetails.email">
                <span class="help-block text-danger" v-if="formErrors.email">{{ formErrors.email[0] }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="password">Password</label>

            <div class="col-md-6">
                <input class="form-control" id="password" name="password" type="password" v-model="registerDetails.password">
                <span class="help-block text-danger" v-if="formErrors.password">{{ formErrors.password[0] }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="password-confirm">Password confirm</label>

            <div class="col-md-6">
                <input class="form-control" id="password-confirm" name="password_confirmation" type="password" v-model="registerDetails.password_confirmation">
                <span class="help-block text-danger" v-if="formErrors.password_confirmation">{{ formErrors.password_confirmation[0] }}</span>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <clip-loader :loading="loading" ref="formLoader"></clip-loader>
                <button :disabled="loading" class="btn btn-primary" type="submit">
                    Register
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    import Message from './MessageComponent.vue';
    import ClipLoader from 'vue-spinner/src/ClipLoader.vue';

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components: {
            Message,
            ClipLoader
        },
        data: function () {
            return {
                registerDetails: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                formErrors: {},
                loading: false
            }
        },
        props: ['csrf_token', 'register_route', 'login_route'],

        methods: {
            registerPost: function (event) {

                let vm = this;
                vm.loading = true;

                event.preventDefault();
                // perform ajax
                axios.post(this.register_route, vm.registerDetails)
                    .then(function (response) {
                        vm.loading = false;
                        var result = response.data;
                        if (result.status === true) {
                            vm.$refs.formMessage.flash('alert-success', 'Success:', 'Thank you for registering. An activation mail has been send to ' + vm.registerDetails.email + '.');
                        }
                    })
                    .catch(function (error) {
                        vm.loading = false;
                        var errors = error.response.data;
                        vm.formErrors = errors.errors;
                        vm.$refs.formMessage.flash('alert-danger', 'Error:', 'An error occurred.');
                    });
            }
        }
    }
</script>
