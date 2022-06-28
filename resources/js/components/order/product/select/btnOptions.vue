<template>
    <div>
        <v-dialog v-model="dialog" persistent scrollable width="500">
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="info">
                    <v-icon left> settings </v-icon>
                    หมวด
                </v-btn></template
            >
            <v-card>
                <v-card-title class="text-h5 white">
                    <v-icon left>settings</v-icon>
                    หมวด
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="exit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text> <options></options> </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import options from "@/js/components/order/product/select/options";
export default {
    components: { options },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        exit() {
            this.$emit("emitLoadAgain");
            this.dialog = false;
        },
    },
};
</script>
