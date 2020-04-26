<template>
    <div>
        <v-row>
            <v-col cols="6" md="6" sm="6">ยอดรวมทั้งหมด</v-col>
            <v-col cols="6" md="6" sm="6" class="text-right"
                >{{ sum.total }} บาท</v-col
            >
        </v-row>
        <v-row>
            <v-col cols="6" md="6">ยอดชำระแล้ว</v-col>
            <v-col cols="6" md="6" class="text-right">{{ sum.deposit }} บาท</v-col>
        </v-row>
        <v-row>
            <v-col cols="6" md="6">ยอดคงเหลือ</v-col>
            <v-col cols="6" md="6" class="text-right">{{ sum.balance }} บาท</v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    props: ["sum"]
};
</script>

<style></style>
