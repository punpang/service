<template>
    <div>
        <v-card class="mb-2" outlined>
            <v-card-title class="text-h6 white--text warning">
                ข้อมูลลูกค้า
            </v-card-title>
            <v-card-text>
                <v-simple-table>
                    <tbody>
                        <tr>
                            <td>
                                <strong>ชื่อ</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{ order.customer.name }}</strong>
                            </td>
                        </tr>
                        <!-- / -->
                        <tr>
                            <td>
                                <strong>เบอร์โทร</strong>
                            </td>
                            <td class="text-right">
                                <strong>{{
                                    user.type == 1
                                        ? order.customer.tel
                                        : order.customer.phone_format
                                }}</strong>
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
            user: "main/User",
        }),
    },
};
</script>
