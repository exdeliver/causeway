<template>
    <div>
    <input name='dateRange' type='text' :value="dateRange" />
    <v-date-picker :formats='formats' :update-on-input='false' v-model='dateRange' :value="null" :mode="mode" is-inline is-expanded :available-dates='availableDates'>
    </v-date-picker>
        <p>
            Input Value: {{ dateRange }}
        </p>
    </div>
</template>

<script>
    import {setupCalendar, Calendar} from 'v-calendar'

    export default {
        components: {
            'v-calendar': Calendar
        },
        data() {
            return {
                dateRange: null,
                mode: 'range',
                formats: {
                    title: 'MMMM YYYY',
                    weekdays: 'W',
                    navMonths: 'MMM',
                    input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
                    dayPopover: 'L', // Only for `v-date-picker`
                },
                availableDates: {
                    start: new Date(2019, 6, 1),
                    end: new Date(2019, 6, 5)
                }
            };
        },
    };

</script>
