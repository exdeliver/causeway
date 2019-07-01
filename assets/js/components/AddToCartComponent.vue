<template>
    <form method="POST" :action="add_to_cart_route" accept-charset="UTF-8" id="shopAddProductToCart" v-on:submit="addToCart">
        <input name="_token" type="hidden" :value="csrf_token">

            <input :name="'products['+product.id+']'" type="number" value="1" aria-label="Quantity" class="form-control" style="width: 100px" v-if="showQuantity == 1">
            <input :name="'products['+product.id+']'" type="hidden" value="1" v-else>

        <button type="submit" for="shopAddProductToCart" class="btn btn-primary btn-md my-0 p" :title="product.title">
            <i class="fa fa-cart-plus"></i> Add to cart
        </button>
    </form>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop add to cart product.');
        },
        props: ['product', 'show_quantity_input', 'add_to_cart_route', 'csrf_token'],
        components: {},
        data: function () {
            return {
                showQuantity: this.show_quantity_input,
                productDetails: {
                    products: {
                        [this.product.id]: 1,
                    }
                },
            }
        },
        created() {
            console.log(this.showQuantity +'s');
        },
        methods: {
            addToCart: function (e) {
                let vm = this;
                e.preventDefault();
                //perform ajax
                axios.post(this.add_to_cart_route, this.productDetails)
                    .then(function (response) {
                        var result = response.data;
                        if (result.status === true) {
                            var jsonData = {type: 'alert-success', title: 'Success!', message: 'Product <strong>' + vm.product.title + '</strong> has been added to your cart..'};
                            EventBus.$emit('status-message', jsonData);
                            EventBus.$emit('cart-totals', jsonData);
                        }
                    })
                    .catch(function (error) {
                        var jsonData = {type: 'alert-danger', title: 'Error', message: 'Something went wrong...'};
                        EventBus.$emit('status-message', jsonData);
                    });
            }
        }
    }
</script>
