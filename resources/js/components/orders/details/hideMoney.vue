<template>
    <div>
        <v-dialog v-model="dialog" persistent width="500">
            <template v-slot:activator="{ on }">
                <v-btn color="light-blue accent-3" block v-on="on">
                    <v-icon left>emoji_emotions</v-icon>
                    บริการซ่อนเงิน</v-btn
                >
            </template>
            <v-card>
                <v-card-title
                    >บริการซ่อนเงิน
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dialog: false
        };
    }
};
</script>

<style></style>
