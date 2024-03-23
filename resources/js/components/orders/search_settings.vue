<template>
    <div>
        <v-dialog width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn class="info" x-large v-on="on" block>
                    <v-icon left>settings</v-icon>
                    ตั้งค่าค้นหา</v-btn
                >
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    ตั้งค่าค้นหา
                </v-card-title>
                <v-card-text class="pa-5">
                    <strong class="text-h5 mb-0">สถานะ</strong>
                    <v-checkbox
                        v-model="search.status"
                        v-for="status in status_items"
                        :key="status.id"
                        :label="status.text"
                        hide-details
                        :value="status.id"
                    ></v-checkbox>
                    <v-divider></v-divider>

                    <v-text-field
                        label="เวลาโหลดข้อมูลใหม่"
                        outlined
                        hide-details
                        v-model="timer.default"
                        suffix="วินาที"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="success" large @click="submit(true)"
                        >ค้นหา</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
export default {
    data() {
        return {
            dialog: false,
            search: {
                status: [1, 2, 3, 4, 8],
            },
            timer: {
                default: 60,
                run: 0,
                status: true,
                running: "",
                set_down_timer: "",
            },
            status_items: [
                { id: 1, text: "คำสั่งซื้อใหม่" },
                { id: 2, text: "รอยืนยันคำสั่งซื้อ" },
                { id: 3, text: "ยืนยันคำสั่งซื้อ" },
                { id: 4, text: "รอเตรียมสินค้า" },
                { id: 8, text: "จัดเตรียมสินค้าแล้ว" },
                { id: 9, text: "รับสินค้าเรียบร้อย" },
                { id: 10, text: "ยกเลิกคำสั่งซื้อ" },
            ],
        };
    },
    methods: {
        submit(click) {
            const payload = {
                search: this.search,
                timer: this.timer,
                click: click,
            };
            this.$emit("submitSearch", payload);
            this.dialog = false;
        },
    },
    async mounted() {
        await this.submit();
    },
};
</script>

<style></style>
