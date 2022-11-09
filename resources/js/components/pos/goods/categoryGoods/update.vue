<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon>more_vert</v-icon>
                </v-btn>
            </template>
            <formCategoryGoods :propCategoryGoods="propCategoryGoods" @emitExit="emitExit"></formCategoryGoods>
        </v-dialog>
    </div>
</template>

<script>
import formCategoryGoods from "@/js/components/pos/goods/categoryGoods/_form";
export default {
    props: ["propCategoryGoods"],
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
        formCategoryGoods,
    },
};
</script>

<style></style>
