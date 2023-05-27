<template>
    <div>
        <v-dialog
            persistent
            width="500"
            v-model="dialog"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-list-item
                    v-on="on"
                    :disabled="
                        propOrderDetail.order_detail_id != null &&
                        propOrderDetail.id != propOrderDetail.order_detail_id
                    "
                >
                    <v-list-item-icon>
                        <v-icon>cake</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="py-2" v-if=" propOrderDetail.order_detail_id != null &&
                        propOrderDetail.id != propOrderDetail.order_detail_id"
                            >เชื่อมเค้กหลายชั้นอยู่</v-list-item-title
                        >

                        <v-list-item-title class="py-2" v-else
                            >เชื่อมเค้กหลายชั้น</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </template>
            <multiCakeForm
                @emitExit="emitExit"
                :propOrderDetail="propOrderDetail"
            ></multiCakeForm>
        </v-dialog>
    </div>
</template>

<script>
import multiCakeForm from "@/js/components/order/manages/goods/cake/multiCake/_form";
export default {
    props: ["propOrderDetail"],
    components: {
        multiCakeForm,
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
