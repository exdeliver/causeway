<template>
    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-shopping-cart"></i>
        <span v-if="cartDetails.quantity > 0">{{ cartDetails.quantity }}</span>
        <span v-else>0</span>
    </a>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop cart item totals.');
        },
        props: ['cart', 'cart_details_route'],
        components: {},
        data: function () {
            return {
                cartDetails: {
                    quantity: this.cart.quantity
                }
            }
        },
        created() {
            EventBus.$on('cart-totals', obj => {
                this.refreshRates();
            });
        },
        methods: {
            refreshRates: function (e) {
                let vm = this;
                //perform ajax
                axios.get(this.cart_details_route)
                    .then(function (response) {
                        var result = response.data;
                        vm.cartDetails.quantity = result.quantity;
                    })
                    .catch(function (error) {

                    });
                return false;
            }
        }
    }
</script>
