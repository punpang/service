<template>
    <div>
        <v-tabs v-model="tab">
            <v-tab>คูปอง</v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item>
                <tableCoupons></tableCoupons>
            </v-tab-item>
        </v-tabs-items>
    </div>
</template>

<script>
import tableCoupons from "@/js/pages/coupons/table";
export default {
    components: { tableCoupons },
    data() {
        return {
            tab: null,
        };
    },
};
</script>

<style></style>
