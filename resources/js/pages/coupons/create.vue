<template>
    <div>
        <v-dialog persistent width="800" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    class="deep-orange d-none d-sm-flex"
                    dark
                    @click="clickStart()"
                >
                    <v-icon left> add</v-icon>
                    สร้างคูปอง
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
                    <v-icon> add</v-icon>
                </v-btn>
            </template>
            <formCoupon @emitExit="emitExit"></formCoupon>
        </v-dialog>
    </div>
</template>

<script>
import formCoupon from "@/js/pages/coupons/_form";
export default {
    components: { formCoupon },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitExit() {
            this.dialog = false;
            this.$emit("emitExit");
        },
        clickStart() {},
    },
    computed: {},
};
</script>

<style></style>
