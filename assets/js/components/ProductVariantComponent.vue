<template>
    <div id="variantProduct">
        <p class="alert alert-info">Define your variants below and drag them in the right order to generate all possible combinations.</p>
        <draggable v-model="variantsArray" group="variants" @start="drag=true" @end="updateOrderVariant">
            <div v-for="(element, index) in variantsArray" :key="element.id">
                <div class="card">
                    <div class="card-header draggable">
                        Variant Type
                    </div>
                    <div class="card-body">
                        <div class="form-row variant-row">
                            <div class="input-group col-md-12">
                                <div class="input-group-prepend">
                                    <button class="btn btn-danger" type="button" @click="removeVariant(index)"><i class="fa fa-remove"></i></button>
                                </div>
                                <input type="text" v-model="element.name" :name="'variant['+element.id+'][name]'" class="form-control" id="variant_type"/>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" @click="newVariant(index)">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="alert alert-info">
                            Define your variant type values. You may drag and drop them in a new order.
                        </p>
                        <draggable v-model="element.values" group="elementValues" @start="drag=true" @end="updateOrderValues(index)">
                            <div v-for="(elementValue, valueIndex) in element.values" :key="elementValue.id">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-danger" type="button" @click="removeValue(index, valueIndex)"><i class="fa fa-remove"></i></button>
                                        </div>
                                        <input type="text" v-model="elementValue.name" :name="'variant['+element.id+'][values]['+elementValue.id+'][name]'" class="form-control" id="variant_value"/>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" @click="newValue(index)">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </draggable>
                    </div>
                </div>
            </div>
        </draggable>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        components: {
            draggable
        },
        props: ['product', 'variants'],
        created() {
            this.variantsArray = [this.variants];
        },
        data() {
            return {
                variantsArray: null,
                productDetails: null,
            };
        },
        methods: {
            updateOrderVariant: function () {
                // get your info then...
                var items = this.variantsArray.map(function (item, index) {
                    return {item: item, order: index}
                });

                //console.log(items);
            },
            updateOrderValues: function (elementIndex) {
                // get your info then...
                var items = this.variantsArray[elementIndex].map(function (item, index) {
                    return {item: item, order: index}
                });

                //console.log(items);
            },
            newVariant: function (elementIndex) {
                let variantsCount = this.variantsArray.length + 1;
                let valuesCount = this.variantsArray[elementIndex].values.length + 1;
                this.variantsArray.push({
                    id: variantsCount++, name: "", values: [
                        {
                            id: valuesCount++, name: ""
                        },
                    ]
                });
                console.log(this.variantsArray[elementIndex]);
            },
            removeVariant: function (elementIndex) {
                this.variantsArray.splice(elementIndex, 1);
            },
            newValue: function (elementIndex) {
                let valuesCount = this.variantsArray[elementIndex].values.length + 1;
                this.variantsArray[elementIndex].values.push({
                    id: valuesCount++, name: ""
                })
            },
            removeValue: function (elementIndex, valueIndex) {
                this.variantsArray[elementIndex].values.splice(valueIndex, 1);
            },
        }
    };
</script>
