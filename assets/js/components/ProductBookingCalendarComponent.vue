<template>
    <div>
        <input name='booking[dateRange]' type='text' :value="dateRange"/>
        <v-date-picker :formats='formats' :update-on-input='false' v-model='dateRange' :value="null" :mode="mode" is-inline is-expanded :available-dates='availableDates'>
        </v-date-picker>
        <p>
            Input Value: {{ dateRange }}
        </p>
    </div>
</template>

<script>
    import {Calendar} from 'v-calendar'


    export default {
        components: {
            'v-calendar': Calendar
        },
        props: ['product', 'bookings'],
        created() {
            this.bookingsArray = this.bookings;
            this.errors = this.formErrors;
        },
        data() {
            return {
                bookingsArray: this.bookings,
                dateRange: null,
                mode: 'range',
                formats: {
                    title: 'MMMM YYYY',
                    weekdays: 'W',
                    navMonths: 'MMM',
                    input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
                    dayPopover: 'L', // Only for `v-date-picker`
                },
                availableDates: this.bookings,
            };
        },
    };
</script>
