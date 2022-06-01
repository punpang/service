<template>
    <div>
        <v-card>
            <v-card-title class="text-h6 white--text warning">
                เปลี่ยนลูกค้า
                <v-spacer></v-spacer>
                <v-btn icon fab x-small @click="exit()">
                    <v-icon color="white">close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="pa-4">
                <p class="text-h6">ข้อมูลลูกค้า (เดิม)</p>
                <p>ชื่อลูกค้า :: {{ order.customer.name }}</p>
                <p>เบอร์โทรลูกค้า :: {{ order.customer.tel }}</p>
                <v-divider></v-divider>
                <div
                    v-if="
                        newCustomer.id > 0 &&
                        newCustomer.id != order.customer.id
                    "
                >
                    <p class="text-h6">ข้อมูลลูกค้า (ใหม่)</p>
                    <p>ชื่อลูกค้า :: {{ newCustomer.name }}</p>
                    <p>เบอร์โทรลูกค้า :: {{ newCustomer.tel }}</p>
                </div>
                <v-alert
                    type="error"
                    v-else-if="newCustomer.id == order.customer.id"
                >
                    ไม่สามารถเลือกลูกค้าคนเดิมได้</v-alert
                >
                <v-alert type="warning" v-else>โปรดเลือกลูกค้าใหม่</v-alert>
            </v-card-text>
            <v-card-actions>
                <btnSelectCustomer
                    @emitCustomer="emitCustomer"
                ></btnSelectCustomer>
                <v-spacer></v-spacer>
                <v-btn class="error" large @click="exit()">
                    <v-icon left>exit_to_app</v-icon>ออก</v-btn
                >
                <v-btn
                    class="success"
                    large
                    :disabled="
                        !newCustomer.id || newCustomer.id == order.customer.id
                    "
                    @click="clickSave()"
                >
                    <v-icon left>save</v-icon>บันทึก</v-btn
                >
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnSelectCustomer from "@/js/components/order/changeCustomer/btnSelectCustomer";
export default {
    components: { btnSelectCustomer },
    data() {
        return {
            newCustomer: {},
        };
    },
    methods: {
        async clickSave() {
            if (this.newCustomer.id == this.order.customer.id) {
                this.$toast.error("ไม่สามารถเลือกลูกค้าคนเดิมได้");
                return;
            }

            const payload = {
                order_id: this.order.id,
                customer_id: this.newCustomer.id,
            };

            let loader = this.$loading.show();

            const result = await this.$store.dispatch(
                "orderIndex/changeCustomer",
                payload
            );

            if (result.status == 200) {
                this.$toast.success(result.data.message);
                this.newCustomer = {};
                let loader = this.$loading.show();
                await this.$store.dispatch("orderIndex/getOrderByID", {
                    orderID: this.order.id,
                });
                loader.hide();
                this.$emit("emitExit");
            } else {
                this.$toast.error("เกิดข้อผิดพลาดบางประการ ลองใหม่อีกครั้ฃ");
            }

            loader.hide();
        },
        async getData() {
            const result = await this.$store.dispatch(
                "orderIndex/getOrderByID",
                {
                    orderID: this.$route.params.id,
                }
            );
            console.log(result);
        },
        exit() {
            this.$emit("emitExit");
        },
        emitCustomer(v) {
            this.newCustomer = v;
        },
    },
    mounted() {
        this.getData();
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
