<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                ข้อมูลรายการสั่งซื้อ
            </v-card-title>
            <v-card-text>
                <v-simple-table>
                    <tbody>
                        <tr>
                            <td>
                                <strong>หมายเลขคำสั่งซื้อ</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ order.id }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                        <tr>
                            <td>
                                <strong>วัน-เวลารับสินค้า</strong>
                            </td>
                            <td class="text-right">
                                <strong
                                    >{{ order.date_get_th }}
                                    {{ order.time_get_format }}</strong
                                >
                            </td>
                        </tr>
                        <!-- / -->
                        <tr>
                            <td>
                                <strong>วัน-เวลาที่สั่งซื้อ</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ order.created_at_th }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                    </tbody>
                </v-simple-table>
                <v-select
                    :items="fetchChannel"
                    item-text="title"
                    item-value="id"
                    label="ช่องทางการสั่งซื้อ"
                    outlined
                    hide-details
                    class="mt-2"
                    dense
                    v-model="order.order_channel.id"
                    v-if="user.type == 1"
                    @change="changeChannelOrder()"
                ></v-select>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    methods: {
        async changeChannelOrder() {
            let loader = this.$loading.show();
            const payload = {
                order_id: this.order.id,
                order_channel_id: this.order.order_channel.id,
            };

            const result = await this.$store.dispatch(
                "orderIndex/update_channel_order",
                payload
            );

            if (result.status == "success") {
                this.$toast.success(result.message);
            }else{
                this.$toast.error("เปลี่ยนแปลงไม่สำเร็จ โปรดลองอีกครั้ง");
            }
            loader.hide();
        },
    },
    async mounted() {
        let loader = this.$loading.show();
        await this.$store.dispatch("orderChannel/fetchUse");
        loader.hide();
    },
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
            fetchChannel: "orderChannel/fetchUse",
            user: "main/User",
        }),
    },
};
</script>
