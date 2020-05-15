<template>
    <div>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="30%">
                    Description
                </th>
                <th width="10%">
                    Gross Price
                </th>
                <th width="10%">
                    VAT
                </th>
                <th width="10%">
                    Special Price
                </th>
                <th width="10%">
                    Quantity
                </th>
                <th width="10%">

                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in itemsArray" :key="item.id">
                <td>
                    <div class="form-group">
                        <input v-model="item.name" :name="'item['+item.id+'][name]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="item.gross_price" :name="'item['+item.id+'][gross_price]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="item.vat" :name="'item['+item.id+'][vat]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="item.special_price" :name="'item['+item.id+'][special_price]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="item.quantity" :name="'item['+item.id+'][quantity]'" type="text" class="form-control">
                        <input v-model="item.id" :name="'item['+item.id+'][id]'" type="hidden" class="form-control">
                    </div>
                </td>
                <td>
                    <button class="btn btn-success btn-sm pull-left mr-2" type="button" @click="newProduct(index)">
                        <i class="fa fa-plus"></i>
                    </button>

                    <button class="btn btn-danger btn-sm pull-left" type="button" @click="removeProduct(index)">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        components: {
        },
        props: ['products', 'form', 'formErrors'],
        created() {
            this.itemsArray = this.products;
            this.errors = this.formErrors;
        },
        data() {
            return {
                itemsArray: this.items,
                errors: {},
            };
        },
        methods: {
            newProduct: function (elementIndex) {
                let itemsCount = this.itemsArray.length + 1;

                this.itemsArray.push({
                    id: itemsCount++
                });
            },
            removeProduct: function (elementIndex) {
                let itemsCount = this.itemsArray.length;

                if(itemsCount > 1) {
                    this.itemsArray.splice(elementIndex, 1);
                }
            },
        }
    };
</script>
