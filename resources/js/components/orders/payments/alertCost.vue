<template>
    <div>
        <v-dialog v-model="dialog" persistent width="600">
            <template v-slot:activator="{ on }">
                <v-btn color="warning" v-on="on">แจ้งชำระเงิน</v-btn>
            </template>
            <v-card color="#121212">
                <v-card-title>
                    แจ้งชำระเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    dsfkj
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dialog:false
        }
    },
};
</script>

<style></style>
