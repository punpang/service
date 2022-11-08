<template>
    <div>
        <v-dialog
            persistent
            width="800"
            v-model="dialog"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on">
                    <v-list-item-icon>
                        <v-icon>local_atm</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="py-2"
                            >บริการล้อม/ลูกบอล/ซ่อนเงิน/ดึงเงิน</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </template>
            <moneyService
                @emitExit="emitExit"
                :propOrderDetail="propOrderDetail"
            ></moneyService>
        </v-dialog>
    </div>
</template>

<script>
import moneyService from "@/js/components/order/manages/goods/cake/moneyService/_form.vue";
export default {
    props: ["propOrderDetail"],
    components: {
        moneyService,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        async emitExit() {
            await this.$store.dispatch("orderIndex/getOrderByID", {
                orderID: this.$route.params.id,
            });
            this.dialog = false;
        },
    },
};
</script>

<style></style>
