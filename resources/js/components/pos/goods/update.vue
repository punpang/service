<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon>more_vert</v-icon>
                </v-btn>
            </template>
            <formGoods :propGoods="propGoods" @emitExit="emitExit"></formGoods>
        </v-dialog>
    </div>
</template>

<script>
import formGoods from "@/js/components/pos/goods/_form";
export default {
    props: ["propGoods"],
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
        formGoods,
    },
};
</script>

<style></style>
