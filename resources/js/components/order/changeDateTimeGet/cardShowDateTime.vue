<template>
    <div>
        <v-dialog persistent width="500" scrollable v-model="dialog">
            <template v-slot:activator="{ on }">
                <v-btn class="primary" v-on="on" @click="clickStart()">
                    เลือกวัน-เวลา
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    เลือกวัน-เวลา
                    <v-spacer></v-spacer>
                    <v-btn fab icon x-small @click="clickExit()">
                        <v-icon class="white--text">close</v-icon>
                    </v-btn>
                </v-card-title>
                <dataTimeGetShow></dataTimeGetShow>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="error" large @click="clickExit()">
                        <v-icon left>exit_to_app</v-icon>
                        ออก
                    </v-btn>
                    <v-btn
                        class="success"
                        large
                        @click="clickSave()"
                    >
                        <v-icon left>save</v-icon>
                        บันทึก
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import dataTimeGetShow from "@/js/components/order/dataTimeGet/cardShow/show";
import { mapGetters } from "vuex";
export default {
    props: ["propDataTimeGet"],
    components: { dataTimeGetShow },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        clickStart() {
            this.$store.commit(
                "orderTemp/setDateGet",
                this.propDataTimeGet.date_get
            );
            this.$store.commit(
                "orderTemp/setTimeGet",
                this.propDataTimeGet.time_get
            );
        },
        clickSave() {
            const dataTimeGet = {
                date_get: this.temp.temp.dateTimeGet.dateGet,
                time_get: this.temp.temp.dateTimeGet.timeGet,
            };
            this.$emit("emitSaveNewDateTime", dataTimeGet);
            this.dialog = false;
        },
        clickExit() {
            this.dialog = false;
        },
    },
    computed: {
        ...mapGetters({
            temp: "orderTemp/temp",
            order: "orderIndex/order",
        }),
    },
};
</script>

<style></style>
