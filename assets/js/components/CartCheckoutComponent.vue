<template>
    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr class="first last">
                <th width="50%">
                    <span>Product</span>
                </th>
                <th class="text-center" width="30%">
                    Quantity
                </th>
                <th></th>
                <th class="text-center cart-total-head" width="20%">
                    Gross total
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in cartDetails.items">
                <td>
                    {{ item.name }}
                </td>
                <td class="text-center">
                    {{ item.quantity }}
                </td>
                <td></td>
                <td class="text-center">
                    {{ item.total_gross_price_format }}
                </td>
            </tr>
            <tr class="border-top">
                <td>

                </td>
                <td class="text-center">
                    Subtotal
                </td>
                <td>

                </td>
                <td class="text-center">{{ cartDetails.subtotal }}</td>
            </tr>
            <tr v-for="vat in cartDetails.vats">
                <td>

                </td>
                <td class="text-center">
                    <strong>{{ vat.formatted_vat }}</strong>
                </td>
                <td>

                </td>
                <td class="text-center">
                    {{ vat.formatted_amount }}
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td class="text-center">
                    Total
                </td>
                <td>

                </td>
                <td class="text-center">{{ cartDetails.total }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop cart checkout.');
        },
        props: ['cart', 'cart_details_route'],
        components: {},
        data: function () {
            return {
                cartDetails: {
                    items: JSON.parse(this.cart.items),
                    subtotal: this.cart.subtotal,
                    vats: this.cart.vats,
                    total: this.cart.total
                },
            }
        },
        created() {
            EventBus.$on('cart-checkout-totals', obj => {
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
                        vm.cartDetails.items = JSON.parse(result.items);
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
