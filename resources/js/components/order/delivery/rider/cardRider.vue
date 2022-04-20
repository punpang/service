<template>
    <div>
        <v-card-text class="pa-3">
            <v-text-field
                v-model="propRider.rider_name"
                outlined
                label="ชื่อไรเดอร์"
                hide-details
                class="mb-4"
            ></v-text-field>
            <v-text-field
                v-model="propRider.rider_phone"
                type="number"
                pattern="\d*"
                outlined
                label="เบอร์โทรไรเดอร์"
                hide-details
                class="mb-4"
            ></v-text-field>
            <v-text-field
                v-model="propRider.rider_link"
                outlined
                label="Rider Link"
                hide-details
                class="mb-4"
            ></v-text-field>
            <v-select
                label="Delivery Platfrom"
                v-model="propRider.delivery_platfrom"
                :items="delivery_platfrom"
                outlined
                hide-details
                class="mb-4"
            ></v-select>
            <v-textarea
                v-model="propRider.rider_remark"
                outlined
                label="หมายเหตุ"
                hide-details
                class="mb-4"
            ></v-textarea>
        </v-card-text>
    </div>
</template>

<script>
export default {
    props: ["propRider"],
    data() {
        return {
            delivery_platfrom: ["Grab Express", "FoodPanda", "ร้าน"],
        };
    },
};
</script>

<style></style>
