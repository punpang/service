<template>
    <div>
        <v-dialog v-model="dialog" persistent scrollable width="800">
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon color="warning">edit</v-icon>
                </v-btn></template
            >
            <v-card>
                <moneyService
                    :propMoneyService="propMoneyService"
                    @emitExit="emitExit"
                ></moneyService>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import moneyService from "@/js/components/order/manages/goods/cake/moneyService/_form.vue";

export default {
    props: ["propMoneyService"],
    components: { moneyService },
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
