<template>
    <div>
        {{ date }}
        <v-btn @click="fetch()">fetch</v-btn>
        <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :return-value.sync="date"
            transition="scale-transition"
            offset-y
            min-width="auto"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="date"
                    label="Picker in menu"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    outlined
                ></v-text-field>
            </template>
            <v-date-picker v-model="date" no-title scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="menu = false">
                    Cancel
                </v-btn>
                <v-btn text color="primary" @click="$refs.menu.save(date)">
                    OK
                </v-btn>
            </v-date-picker>
        </v-menu>
        {{ orders }}
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            menu: false,
            date: "",
        };
    },
    methods: {
        async fetch() {
            const payload = `date_get=${this.date}&sort_time_get=asc&makeHidden=sum_all&with=aStatus`;
            const result = await this.$store.dispatch(
                "orderIndex/fetch_orders",
                payload
            );
        },
    },
    computed: {
        ...mapGetters({
            orders: "orderIndex/orders",
        }),
    },
};
</script>

<style></style>
