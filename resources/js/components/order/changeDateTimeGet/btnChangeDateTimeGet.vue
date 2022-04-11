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
                        เปลี่ยนวัน-เวลานัดรับสินค้า
                    </v-list-item-title>
                </v-list-item>
            </template>

            <v-card>
                <cardChangeDatetime @emitExit="emitExit"></cardChangeDatetime>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardChangeDatetime from "@/js/components/order/changeDateTimeGet/cardChangeDatetime";
export default {
    components: { cardChangeDatetime },
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
