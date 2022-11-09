<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    class="deep-orange d-none d-sm-flex"
                    dark
                    @click="clickStart()"

                >
                    <v-icon left> add</v-icon>
                    สร้างสินค้า
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
            <formGoods @emitExit="emitExit"></formGoods>
        </v-dialog>
    </div>
</template>

<script>
import formGoods from "@/js/components/pos/goods/_form";
export default {
    components: { formGoods },
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
    computed: {},
};
</script>

<style></style>
