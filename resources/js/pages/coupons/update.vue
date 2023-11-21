<template>
    <div>
        <v-dialog persistent width="800" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon>more_vert</v-icon>
                </v-btn>
            </template>
            <formCoupon :propCoupon="propCoupon" @emitExit="emitExit"></formCoupon>
        </v-dialog>
    </div>
</template>

<script>
import formCoupon from "@/js/pages/coupons/_form";
export default {
    props: ["propCoupon"],
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
    },
    components: {
        formCoupon,
    },
};
</script>

<style></style>
