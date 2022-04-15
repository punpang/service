<template>
    <div>
        <v-text-field
            label="ชื่อผู้รับ *"
            outlined
            hide-details
            class="mb-4"
            v-model="propForm.recipient_name"
            :readonly="propForm.customerBuyer == true"
        ></v-text-field>
        <v-text-field
            label="เบอร์โทรผู้รับ *"
            outlined
            hide-details
            class="my-4"
            v-model="propForm.recipient_phone"
            type="number"
            pattern="\d*"
            :readonly="propForm.customerBuyer == true"
        ></v-text-field>
        <v-checkbox
            label="ข้อมูลเดียวกับผู้สั่งซื้อ"
            outlined
            hide-details
            class="my-4"
            v-model="propForm.customerBuyer"
            @click="clickCustomerBuyer()"
        ></v-checkbox>
        <v-divider></v-divider>
        <v-text-field
            label="ค่าบริการจัดส่ง *"
            outlined
            hide-details
            class="my-4"
            type="number"
            pattern="\d*"
            v-model="propForm.delivery_fee"
            suffix="บาท"
        ></v-text-field>

        <v-text-field
            label="Link Google Maps *"
            outlined
            hide-details
            class="my-4"
            v-model="propForm.link_google_maps"
        >
        </v-text-field>
        <v-textarea
            label="รายละเอียดเพิ่มเติม"
            outlined
            hide-details
            class="my-4"
            v-model="propForm.detail"
        ></v-textarea>
    </div>
</template>

<script>
export default {
    props: ["propForm"],
    methods: {
        clickCustomerBuyer() {
            this.$emit("emitCustomerBuyer");
        },
    },
};
</script>
