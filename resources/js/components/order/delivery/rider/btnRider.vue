<template>
    <div>
        <v-dialog
            width="500"
            scrollable
            persistent
            v-model="dialog"
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="success">
                    <v-icon left>local_shipping</v-icon>

                    ทำการจัดส่ง</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ทำการจัดส่ง
                    <v-spacer></v-spacer>
                    <v-btn
                        fab
                        x-small
                        icon
                        color="white--text"
                        @click="close()"
                    >
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <cardRider :propRider="rider"></cardRider>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import cardRider from "@/js/components/order/delivery/rider/cardRider";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            rider: {
                rider_name: "",
                rider_phone: "",
                rider_remark: "",
                rider_link: "",
                delivery_plateform: "",
            },
        };
    },
    components: { cardRider },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>

<style></style>
