<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn class="primary" large v-on="on">
                    <v-icon left>search</v-icon>

                    เลือกลูกค้า</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    เปลี่ยนลูกค้า > เลือกลูกค้า</v-card-title
                >
                <v-card-text class="pa-4">
                    <cardSearch @emitSave="emitSave"></cardSearch>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardSearch from "@/js/components/order/customer/cardSearch/cardSearch";
import { mapGetters } from "vuex";
export default {
    components: {
        cardSearch,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitSave() {
            this.$emit("emitCustomer", this.getSearch);
            this.dialog = false;
        },
        emitExit()
        {
            this.dialog = false;
        }
    },
    computed: {
        ...mapGetters({
            getSearch: "orderCustomer/getSearch",
        }),
    },
};
</script>

<style></style>
