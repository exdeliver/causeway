<template>
    <form :action="login_route" id="login-form" method="POST" v-on:submit="loginPost">
        <message ref="formMessage"></message>
        <input :value="csrf_token" name="_token" type="hidden"/>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="email">E-mail address</label>

            <div class="col-md-6">
                <input autofocus class="form-control" id="email" name="email" type="email" v-model="loginDetails.email">
                <span class="help-block text-danger" v-if="formErrors.email">{{ formErrors.email[0] }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="password">Password</label>

            <div class="col-md-6">
                <input class="form-control" id="password" name="password" type="password" v-model="loginDetails.password">
                <span class="help-block text-danger" v-if="formErrors.password">{{ formErrors.password[0] }}</span>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox">

                    <label class="form-check-label" for="remember">
                        Remember me?
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button class="btn btn-primary" type="submit">
                    Login
                </button>
                <clip-loader :loading="loading" ref="formLoader"></clip-loader>
                <a :href="request_password_route" class="btn btn-link">
                    Forgot password?
                </a>
            </div>
        </div>
    </form>
</template>

<script>
    import Message from './MessageComponent.vue';
    import ClipLoader from 'vue-spinner/src/ClipLoader.vue';

    export default {
        mounted() {
            console.log('Login mounted.')
        },
        components: {
            Message,
            ClipLoader
        },
        data: function () {
            return {
                loginDetails: {
                    email: '',
                    password: ''
                },
                formErrors: {},
                loading: false
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message)
            }
        },
        props: ['csrf_token', 'login_route', 'request_password_route'],

        methods: {
            loginPost: function (event) {

                let vm = this;
                vm.loading = true;
                event.preventDefault();

                // perform ajax
                axios.post(this.login_route, vm.loginDetails)
                    .then(function (response) {
                        vm.loading = false;
                        var result = response.data;
                        if (result.status === true) {
                            vm.$refs.formMessage.flash('alert-success', 'Success:', 'You are logged in. Redirecting...');
                            location.reload();
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
