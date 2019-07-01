<template>
    <tr>
        <td>
            <div class="pull-left">
                <a :href="product._link" title="product.name">
                    <img src="https://via.placeholder.com/80" alt="Placeholder" title="Product name" class="mr-2 max-w-sm rounded overflow-hidden border border-gray-400 shadow-sm"/>
                </a>
            </div>
            <div class="pull-left">
                <p>
                    <a :href="product._link" title="product.name"><strong>{{ product.name }}</strong></a>
                </p>
            </div>
            <div class="clearfix"></div>
        </td>
        <td class="text-center">
            <div class="input-group">
                <div class="input-group-append">
                    <a id="productSub" href="#" class="btn btn-primary" v-on:click="subProduct">
                        <i class="fa fa-minus-circle"></i>
                    </a>
                </div>
                <input type="number" class="form-control text-center" for="shopCartForm" v-model="productDetails.products[this.product.product_id]" :name="'products['+product.id+'][quantity]'"/>
                <div class="input-group-append">
                    <a id="productPlus" href="#" class="btn btn-primary" v-on:click="plusProduct">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                </div>
            </div>
        </td>
        <td>

        </td>
        <td class="text-center">
            <span v-if="product.original_vat_price > product.vat_price">
                <strike>{{ product.original_vat_price_format }}</strike>
            </span>
            <span id="productTotalPrice">{{ product.vat_price_format }}</span>
        </td>
        <td class="text-center">
            <a href="#" @click="removeProduct"><i class="fa fa-remove"></i></a>
        </td>
    </tr>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop cart product.');
        },
        props: ['product', 'add_to_cart_route'],
        components: {},
        data: function () {
            return {
                productDetails: {
                    products: {
                        [this.product.product_id]: this.product.quantity,
                    }
                },
            }
        },
        created() {
console.log(this.product);
        },
        methods: {
            plusProduct: function (e) {
                let vm = this;
                vm.productDetails.products[this.product.product_id]++;
                setNewCartValue(e, vm, vm.productDetails.products[this.product.product_id]);
            },
            subProduct: function (e) {
                let vm = this;
                if(vm.productDetails.products[this.product.product_id] >= 1) {
                    vm.productDetails.products[this.product.product_id]--;
                    setNewCartValue(e, vm, vm.productDetails.products[this.product.product_id]);
                }
            },
            removeProduct: function (e) {
                let vm = this;
                vm.productDetails.products[this.product.product_id] = 0;
                setNewCartValue(e, vm, vm.productDetails.products[this.product.product_id]);
            },
        }
    }

    /**
     * Set the cart value.
     *
     * @param event
     * @param object
     * @param value
     */
    function setNewCartValue(event, object, value) {
        let vm = object;
        event.preventDefault();
        //perform ajax
        axios.post(vm.add_to_cart_route, vm.productDetails)
            .then(function (response) {
                var result = response.data;
                if (result.status === true) {
                    var jsonData = {type: 'alert-success', title: 'Success!', message: 'Product <strong>'+vm.product.name+'</strong> quantity updated..'};
                    EventBus.$emit('status-message', jsonData);
                    EventBus.$emit('cart-totals', jsonData);
                }
            })
            .catch(function (error) {
                var jsonData = {type: 'alert-danger', title: 'Error', message: 'Something went wrong...'};
                EventBus.$emit('status-message', jsonData);
            });
    }
</script>
