<template>
    <div>
        <v-dialog
            ref="dialog"
            v-model="dialog"
            persistent
            width="290px"
            :return-value.sync="timeGet"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-bind="attrs"
                    v-on="on"
                    v-model="temp.temp.dateTimeGet.timeGet"
                    hide-details
                    :prepend-icon="msgDateTimeGet.icon.timeGet"
                    :label="msgDateTimeGet.text.timeGet"
                    outlined
                    readonly
                    :rules="rules.timeGet"
                    class="mb-4"
                ></v-text-field>
            </template>
            <v-time-picker
                v-if="dialog"
                :allowed-minutes="allowedMinutes"
                :allowed-hours="allowedHours"
                v-model="temp.temp.dateTimeGet.timeGet"
                scrollable
                full-width
                min="9:00"
                max="18:30"
                format="24hr"
            >
                <v-spacer></v-spacer>
                <v-btn text color="error" @click="dialog = false">
                    ออก
                </v-btn>
                <v-btn text color="primary" @click="clickSetTime()"> เลือก </v-btn>
            </v-time-picker>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            dialog: false,
            timeGet: "",
        };
    },
    methods: {
        allowedHours(v) {
            const date = new Date().toISOString().substr(0, 10);
            if (date == this.temp.temp.dateTimeGet.dateGet) {
                const time = new Date().getHours();
                return v > time;
            }
            return v;
        },
        allowedMinutes: (v) => v % 30 == 0,
        clickSetTime() {
            this.$emit("emitTimeGet");
            this.$refs.dialog.save(this.temp.temp.dateTimeGet.timeGet);
            this.dialog = false;
        },
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
