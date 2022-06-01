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
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters({
            order: "orderIndex/order",
        }),
    },
};
</script>
