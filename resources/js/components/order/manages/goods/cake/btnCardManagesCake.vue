<template>
    <div>
        <v-dialog
            persistent
            width="350"
            v-model="dialog"
            scrollable
            transition="dialog-top-transition"
        >
            <template v-slot:activator="{ on }">
                <v-btn x-small class="white" elevation="0" v-on="on">
                    <v-icon>more_horiz</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6">
                    การจัดการ
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-list>
                        <v-list-item-group>
                            <editCake
                                :propOrderDetail="propOrderDetail"
                            ></editCake>
                            <cardManageAddOn
                                :propOrderDetail="propOrderDetail"
                            ></cardManageAddOn>
                            <btnUploadProductPrototype
                                :propOrderDetail="propOrderDetail"
                            ></btnUploadProductPrototype>
                            <btnUploadProductPrototype
                                :propOrderDetail="propOrderDetail"
                            ></btnUploadProductPrototype>
                            <btnMoneyService
                                :propOrderDetail="propOrderDetail"
                            ></btnMoneyService>
                        </v-list-item-group>
                    </v-list>
                    <!-- <editCake
                        :propOrderDetail="propOrderDetail"
                        :propBlock="true"
                    ></editCake>
                    <cardManageAddOns
                        :propOrderDetail="propOrderDetail"
                        :propBlock="true"
                    ></cardManageAddOns>
                    <btnUploadProductPrototype
                        :propOrderDetail="propOrderDetail"
                        :propBlock="true"
                    ></btnUploadProductPrototype> -->
                    <v-divider class="my-1"></v-divider>
                    <btnSwitchUploadImageFromCustomer
                        :propOrderDetail="propOrderDetail"
                    ></btnSwitchUploadImageFromCustomer>
                    <btnSwitchTakeAPhoto
                        :propOrderDetail="propOrderDetail"
                    ></btnSwitchTakeAPhoto>
                    <v-divider class="my-1"></v-divider>
                    <removeCake
                        :propOrderDetail="propOrderDetail"
                        :propBlock="true"
                    ></removeCake>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import editCake from "@/js/components/order/manages/goods/cake/editCake";
import removeCake from "@/js/components/order/manages/goods/cake/removeCake";
import cardManageAddOn from "@/js/components/order/manages/goods/cake/addOn/cardManageAddOn";
import btnUploadProductPrototype from "@/js/components/order/manages/goods/cake/productPrototype/btnUploadProductPrototype";
import btnSwitchUploadImageFromCustomer from "@/js/components/order/manages/goods/cake/btnSwitchUploadImageFromCustomer";
import btnSwitchTakeAPhoto from "@/js/components/order/manages/goods/cake/btnSwitchTakeAPhoto";
import btnMoneyService from "@/js/components/order/manages/goods/cake/moneyService/btn";
export default {
    props: ["propOrderDetail"],
    components: {
        editCake,
        removeCake,
        cardManageAddOn,
        btnUploadProductPrototype,
        btnSwitchUploadImageFromCustomer,
        btnSwitchTakeAPhoto,
        btnMoneyService,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        exit() {
            this.dialog = false;
        },
    },
};
</script>
