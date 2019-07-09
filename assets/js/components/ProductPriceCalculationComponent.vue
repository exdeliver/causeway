<template>
    <div>
        <div class="form-group">
            <label for="gross_price">Gross price</label>
            <input name="gross_price" type="text" class="form-control" id="gross_price" v-model="productDetails.gross_price" @change="updateRates" :form="form">
            <span class="invalid-feedback  d-block" role="alert" v-if="formErrors.gross_price">
                 <strong v-for="value in formErrors.gross_price">{{ value }}</strong>
                </span>
            <p class="alert alert-info"><i class="fa fa-question"></i> The gross price of the product.
            </p>
        </div>

        <div class="form-group">
            <label for="special_price">Special price</label>
            <input name="special_price" type="text" class="form-control" value="" id="special_price" v-model="productDetails.special_price" @change="updateRates" :form="form">
            <span class="invalid-feedback  d-block" role="alert" v-if="formErrors.special_price">
                 <strong v-for="value in formErrors.special_price">{{ value }}</strong>
                </span>
            <p class="alert alert-info">
                <i class="fa fa-question"></i> Discounted gross price of the product.
            </p>
        </div>

        <div class="form-group">
            <label for="vat">VAT amount</label>
            <select name="vat" class="form-control" id="vat" v-model="productDetails.vat" @change="updateRates" :form="form">
                <option v-for="(value, key) in vat_list" :value="key">{{ value }}</option>
            </select>
            <span class="invalid-feedback  d-block" role="alert" v-if="formErrors.vat">
                    <strong v-for="value in formErrors.vat">{{ value }}</strong>
                </span>
            <p class="alert alert-info"><i class="fa fa-question"></i> The VAT percentage to calculate the VAT price.
            </p>
        </div>

        <div class="form-group">
            <label for="vat_price">VAT price</label>
            <p v-if="productDetails.special_price > 0 && productDetails.special_price < productDetails.gross_price"><span class="badge badge-info">Discount</span>&nbsp;<strike>{{ productDetails.vat_gross_price }}</strike></p>
            <input name="vat_price" type="text" class="form-control" id="vat_price" v-model="productDetails.vat_price" readonly :form="form">
            <p class="alert alert-info"><i class="fa fa-question"></i> The VAT price of the product.
            </p>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Shop calculate price product.');
        },
        props: ['product', 'vat_list', 'errors', 'form'],
        components: {},
        data: function () {
            return {
                productDetails: {
                    vat: this.product.vat,
                    gross_price: this.formatPrice(this.product.gross_price / 100),
                    vat_price: this.formatPrice(this.product.vat_price / 100),
                    vat_gross_price: this.formatPrice(this.product.vat_price / 100),
                    special_price: this.formatPrice(this.product.special_price / 100),
                },
                formErrors: {
                    gross_price: this.errors.gross_price,
                    vat: this.errors.vat,
                }
            }
        },
        created() {
            this.updateRates();
        },
        methods: {
            updateRates: function (e) {
                let vm = this;
                let grossPrice = ((this.productDetails.special_price > 0 && this.productDetails.special_price < this.productDetails.gross_price) ? this.productDetails.special_price : this.productDetails.gross_price);

                vm.productDetails.vat = this.productDetails.vat;
                vm.productDetails.vat_price = this.formatPrice((grossPrice * ((this.productDetails.vat / 100) + 1)));
                vm.productDetails.vat_gross_price = this.formatPrice((this.productDetails.gross_price * ((this.productDetails.vat / 100) + 1)));
            },
            formatPrice(value) {
                let val = (value / 1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
            }
        }
    }
</script>
