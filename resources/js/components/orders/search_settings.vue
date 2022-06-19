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
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="success" large @click="submit()">ค้นหา</v-btn>
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
                status: [1, 2, 4, 8],
            },
            status_items: [
                { id: 1, text: "รายการใหม่" },
                { id: 2, text: "ยืนยันการสั่งซื้อ" },
                { id: 4, text: "รอเตรียมสินค้า" },
                { id: 8, text: "เตรียมสินค้า" },
                { id: 9, text: "รับสินค้า" },
                { id: 10, text: "ยกเลิก" },
            ],
        };
    },
    methods: {
        submit() {
            this.$emit("submitSearch", this.search);
            this.dialog = false;
        },
    },
    async mounted() {
        await this.submit();
    },
};
</script>

<style></style>
