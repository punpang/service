<template>
    <div>
        <h5>โปรดรับทราบเงื่อนไข</h5>
        <v-checkbox
            v-model="conditions.deposit"
            hide-details
            class="mt-0"
            label="หากท่านยกเลิกรายการสั่งซื้อนี้ ทางร้านขอสงวนสิทธิ์ ไม่คืนเงินมัดจำทั้งจำนวน แต่ทางร้านจะออกคูปองเงินสด เท่ากับยอดชำระมัดจำทั้งจำนวน เพื่อใช้แทนเงินสดและใช้เลือกซื้อสินค้าภายในร้าน"
            :rules="[v => v === true]"
            @change="changeConditions"
        ></v-checkbox>
        <v-checkbox
            v-model="conditions.dateTime_get"
            hide-details
            class="mt-0"
            :label="
                'ท่านสามารถรับสินค้าได้ตั้งแต่ ' +
                    1 +
                    ' หรือหลังจากได้รับข้อความแจ้งว่า ทางร้านได้จัดเตรียมสินค้าของท่านเสร็จแล้ว'
            "
            :rules="[v => v === true]"
        ></v-checkbox>
        <v-checkbox
            v-model="conditions.acceptAll"
            hide-details
            class="mt-0"
            label="ท่านได้รับทราบและยอมรับเงื่อนไขทั้งหมดแล้ว"
            :rules="[v => v === true]"
        ></v-checkbox>
    </div>
</template>

<script>
export default {
    props: ["conditions"],
    methods: {
        changeConditions() {
            const data = {
                deposit: this.conditions.deposit,
                dateTime_get: this.conditions.dateTime_get,
                acceptAll: this.conditions.acceptAll
            };
            this.$emit("emitConditions", data);
        }
    }
};
</script>

<style></style>
