<template>
    <form :action="request_password_route" method="POST" v-on:submit="requestPasswordPost">
        <input :value="csrf_token" name="_token" type="hidden"/>

        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right" for="email">E-mail address</label>

            <div class="col-md-6">
                <input autofocus class="form-control" id="email" name="email" type="email" v-model="requestPasswordDetails.email">
                <span class="help-block text-danger" v-if="formErrors.email">{{ formErrors.email[0] }}</span>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button class="btn btn-primary" type="submit">
                    Request password
                </button>

                <a :href="login_route" class="btn btn-link">
                    Login
                </a>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data: function () {
            return {
                requestPasswordDetails: {
                    email: ''
                },
                formErrors: {}
            }
        },
        props: ['csrf_token', 'login_route', 'request_password_route'],

        methods: {
            requestPasswordPost: function (event) {

                let vm = this;

                event.preventDefault();

                // perform ajax
                axios.post(this.request_password_route, vm.requestPasswordDetails)
                    .then(function (response) {
                        var result = response.data;

                        if (result.status === true) {
                            console.log(result.message);
                        }
                    })
                    .catch(function (error) {
                        var errors = error.response.data;
                        vm.formErrors = errors.errors;
                    });
            }
        }
    }
</script>
