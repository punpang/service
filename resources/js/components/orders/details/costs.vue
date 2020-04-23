<template>
    <v-card>
        <v-card-title>
            ค่าใช้จ่าย
        </v-card-title>
        <v-divider class="ma-1"></v-divider>
        <v-card-text class="px-0 pt-0">
            <v-container class="py-0">
                <v-row>
                    <v-col cols="12" md="12" class="py-0">
                        <v-row>
                        <v-col cols="6" md="6" sm="6">ยอดรวมทั้งหมด</v-col>
                        <v-col cols="6" md="6" sm="6" class="text-right">{{ cost.sumPrice }}</v-col>
                        </v-row>
                        <v-spacer></v-spacer>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ["cost"],
};
</script>

<style></style>
