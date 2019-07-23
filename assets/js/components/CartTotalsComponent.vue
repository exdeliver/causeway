<template>
    <div>
        <p>Subtotal: <span>{{ cartDetails.subtotal }}</span></p>
        <p v-for="vat in cartDetails.vats">{{ vat.formatted_vat }}: {{ vat.formatted_amount }}</p>
        <hr/>
        <p>Total: <span>{{ cartDetails.total }}</span><br/>
            <small>Including vat</small>
        </p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop cart totals.');
        },
        props: ['cart', 'cart_details_route'],
        components: {},
        data: function () {
            return {
                cartDetails: {
                    subtotal: this.cart.subtotal,
                    vats: this.cart.vats,
                    total: this.cart.total
                },
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
                        vm.cartDetails.subtotal = result.subtotal;
                        vm.cartDetails.vats = result.vats;
                        vm.cartDetails.total = result.total;
                    })
                    .catch(function (error) {

                    });
                return false;
            }
        }
    }
</script>
