<template>
    <div>
        <p class="alert alert-info">
            Make a selection of dates below when your product/service is bookable. Press the <code>+</code> button for another input field.
        </p>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th width="20%">
                    Type
                </th>
                <th width="20%">
                    Date from / Date To
                </th>
                <th width="10%">
                    Gross Price
                </th>
                <th width="10%">
                    Special Price
                </th>
                <th width="10%">
                    Available
                </th>
                <th width="10%">

                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(booking, index) in bookingsArray" :key="booking.id">
                <td>
                    <div class="form-group">
                        <input v-model="booking.type" :name="'booking['+booking.id+'][type]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">From</span>
                        </div>
                        <datepicker placeholder="Select Date" :disabledDates="disabledDates" v-model="booking.date_from" :name="'booking['+booking.id+'][date_from]'" class="form-control"></datepicker>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">To</span>
                        </div>
                        <datepicker placeholder="Select Date" :disabledDates="disabledDates" v-model="booking.date_to" :name="'booking['+booking.id+'][date_to]'" class="form-control"></datepicker>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="booking.gross_price" :name="'booking['+booking.id+'][gross_price]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="booking.special_price" :name="'booking['+booking.id+'][special_price]'" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input v-model="booking.quantity" :name="'booking['+booking.id+'][quantity]'" type="text" class="form-control">
                        <input v-model="booking.id" :name="'booking['+booking.id+'][id]'" type="hidden" class="form-control">
                    </div>
                </td>
                <td>
                    <button class="btn btn-success btn-sm pull-left mr-2" type="button" @click="newBooking(index)">
                        <i class="fa fa-plus"></i>
                    </button>

                    <button class="btn btn-danger btn-sm pull-left" type="button" @click="removeBooking(index)">
                        <i class="fa fa-remove"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },
        props: ['product', 'bookings', 'form', 'formErrors', 'booking_disabled_dates'],
        created() {
            this.bookingsArray = this.bookings;
            this.errors = this.formErrors;
        },
        data() {
            return {
                bookingsArray: this.bookings,
                disabledDates: this.booking_disabled_dates,
                errors: {},
            };
        },
        methods: {
            newBooking: function (elementIndex) {
                let bookingsCount = this.bookingsArray.length + 1;

                this.bookingsArray.push({
                    id: bookingsCount++, date_from: "", date_to: ""});
            },
            removeBooking: function (elementIndex) {
                let bookingsCount = this.bookingsArray.length;

                if(bookingsCount > 1) {
                    this.bookingsArray.splice(elementIndex, 1);
                }
            },
        }
    };
</script>
