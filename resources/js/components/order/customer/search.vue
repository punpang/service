<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn fab icon small color="info" v-on="on">
                    <v-icon>
                        {{ messages.iconSearch }}
                    </v-icon>
                    <!-- {{ messages.titleSearch }} -->
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <h3>{{ messages.titleSearch }}</h3>
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small color="error" @click="close">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <cardSearch
                        @emitSearch="emitSearch"
                        @emitSave="emitSave"
                        @emitReset="emitReset"
                        @emitCountSetTemp="emitCountSetTemp"
                    ></cardSearch>
                    <cardSearchFalse
                        v-if="hasCustomer && !getSearch"
                        :propPhoneNumber="phoneNumber"
                    ></cardSearchFalse>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardSearch from "@/js/components/order/customer/cardSearch/cardSearch";
import cardSearchFalse from "@/js/components/order/customer/cardSearch/cardSearchFalse";
import { mapGetters } from "vuex";

export default {
    components: {
        cardSearch,
        cardSearchFalse,
    },
    data() {
        return {
            dialog: false,
            hasCustomer: false,
            phoneNumber: "",
        };
    },
    methods: {
        emitCountSetTemp() {
            this.$emit("emitCountSetTemp");
        },
        emitSearch(v) {
            this.hasCustomer = true;
            this.phoneNumber = v;
        },
        emitSave() {
            this.close();
        },
        emitReset() {
            this.hasCustomer = false;
        },
        close() {
            // this.phoneNumber = "";
            this.hasCustomer = false;
            this.dialog = false;
        },
    },
    computed: {
        ...mapGetters({
            getSearch: "orderCustomer/getSearch",
            messages: "orderCustomer/messages",
        }),
    },
};
</script>

<style></style>
