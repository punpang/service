<template>
    <div>
        <v-dialog
            ref="dialog"
            v-model="dialog"
            persistent
            width="290px"
            :return-value.sync="date"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="temp.temp.dateTimeGet.dateGet"
                    :label="msgDateTimeGet.text.dateGet"
                    :prepend-icon="msgDateTimeGet.icon.dateGet"
                    readonly
                    outlined
                    hide-details
                    :rules="rules.dateGet"
                    v-bind="attrs"
                    v-on="on"
                    class="mb-4"
                ></v-text-field>
            </template>
            <v-date-picker
                v-model="temp.temp.dateTimeGet.dateGet"
                scrollable
                locale="th-TH"
                :allowed-dates="allowedDates"
            >
                <v-spacer></v-spacer>
                <v-btn text color="error" @click="dialog = false">
                    ออก
                </v-btn>
                <v-btn text color="primary" @click="clickSetDate()"> เลือก </v-btn>
            </v-date-picker>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            date: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            dialog: false,
        };
    },
    methods: {
        allowedDates(val) {
            const subDate = new Date();
            subDate.setDate(subDate.getDate() - 1);
            const date = subDate.toISOString().substr(0, 10);
            return val > date;
        },
        clickSetDate() {
            // this.$emit("emitDateGet");
            this.$refs.dialog.save(this.temp.temp.dateTimeGet.dateGet);
            //   this.$store.commit("orderDateTimeGet/dateGet", this.propDateGet);
            this.dialog = false;
        },
    },
    mounted() {
        this.$emit("emitDateGet", this.temp.temp.dateTimeGet.dateGet);
        // this.$store.commit("orderDateTimeGet/dateGet", this.propDateGet);
    },
    computed: {
        ...mapGetters({
            msgDateTimeGet: "orderDateTimeGet/msg",
            rules: "orderDateTimeGet/rules",
            temp: "orderTemp/temp",
        }),
    },
};
</script>

<style></style>
