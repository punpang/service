<template>
    <div>
        <v-dialog v-model="dialog" width="600" persistent>
            <template v-slot:activator="{ on }">
                <v-btn dark x-small fab color="orange" depressed v-on="on"
                    ><v-icon>search</v-icon></v-btn
                >
            </template>
            <v-card>
                <v-card-text>
                    <CustomerManage
                        :selectCustomer="selectCustomer"
                        @onCustomer="onCustomer"
                    ></CustomerManage>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import CustomerManage from "@/js/pages/orders/customer";
export default {
    components: {
        CustomerManage,
    },
    data() {
        return {
            dialog: false,
            selectCustomer: true,
        };
    },
    methods: {
        onCustomer(value) {
            this.dialog = false;
            this.$emit("onCustomer", value);
        },
    },
};
</script>

<style></style>
