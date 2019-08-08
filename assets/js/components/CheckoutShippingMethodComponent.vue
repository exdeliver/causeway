<template>
    <div style="line-height:40px; vertical-align:top" class="border-b-2 pt-2">
        <div class="form-check">
            <input type="radio" name="shipping" :value="shipping.name" class="form-check-input" style="width:20px;" @change="addToCart"/>
            <label class="form-check-label">
                {{ shipping.label }} {{ shipping.vat_price_formatted }} <span class="badge badge-info" v-if="shipping.is_free_shipping">Free shipping {{ shipping.total_free_shipping_threshold_formatted }}</span>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop show shipping methods');
        },
        props: ['shipping', 'add_to_cart_route', 'csrf_token'],
        components: {},
        data: function () {
            return {
                shippingDetails: {shippingMethod: this.shipping},
            }
        },
        created() {

        },
        methods: {
            addToCart: function (e) {
                let vm = this;
                e.preventDefault();
                //perform ajax
                axios.post(this.add_to_cart_route, this.shippingDetails)
                    .then(function (response) {
                        var result = response.data;
                        if (result.status === true) {
                            EventBus.$emit('cart-checkout-totals', {});
                        }
                    })
                    .catch(function (error) {
                        alert('Something went wrong...');
                    });
            }
        }
    }
</script>
