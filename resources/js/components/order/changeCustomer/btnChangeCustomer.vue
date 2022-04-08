<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="500"
            scrollable
            persistent
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-title class="py-1">
                        เปลี่ยนลูกค้า
                    </v-list-item-title>
                </v-list-item>
            </template>

            <!-- <v-card> -->
            <cardChangeCustomer @emitExit="emitExit"></cardChangeCustomer>
            <!-- </v-card> -->
        </v-dialog>
    </div>
</template>

<script>
import cardChangeCustomer from "@/js/components/order/changeCustomer/cardChangeCustomer";
export default {
    components: { cardChangeCustomer },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitExit() {
            this.dialog = false;
        },
    },
};
</script>
