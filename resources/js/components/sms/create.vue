<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    class="deep-orange d-none d-sm-flex"
                    dark
                    @click="clickStart()"
                >
                    <v-icon left> sms</v-icon>
                    สร้างข้อความ
                </v-btn>

                <v-btn
                    icon
                    fab
                    small
                    v-on="on"
                    class="deep-orange d-flex d-sm-none"
                    dark
                    @click="clickStart()"
                >
                    <v-icon> sms</v-icon>
                </v-btn>
            </template>
            <formMessage @emitExit="emitExit"></formMessage>
        </v-dialog>
    </div>
</template>

<script>
import formMessage from "@/js/components/sms/_form";
export default {
    components: { formMessage },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        clickStart() {},
        emitExit() {
            this.dialog = false;
            this.$emit("emitExit")
        },
    },
};
</script>

<style></style>
