<template>
    <div>
        <v-dialog v-model="dialog" width="80%">
            <template v-slot:activator="{ on }">
                <span v-on="on"
                    >มีรายการสั่งซื้ออื่น จำนวน {{ order.counts }} รายการ
                    <b><u>รายละเอียด</u></b></span
                >
            </template>
            <v-card>
                <v-card-text>
                    <OrderTable
                        :dataTable="order.data"
                        :headers="headers"
                    ></OrderTable>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import OrderTable from "@/js/components/orders/OrderTable";
export default {
    props: ["order",'headers'],
    components: {
        OrderTable
    },
    data() {
        return {
            dialog:false,
        }
    },
};
</script>

<style></style>
