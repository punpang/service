<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon>link</v-icon>
                </v-btn>
            </template>
            <formLinkRawMaterial
                :propGoods="propGoods"
                :propRawMaterial="propRawMaterial"
                :propLinkRawMaterial="propLinkRawMaterial"
                @emitExit="emitExit"
                @emitFetchGoods="emitFetchGoods"
            ></formLinkRawMaterial>
        </v-dialog>
    </div>
</template>

<script>
import formLinkRawMaterial from "@/js/components/pos/goods/link_raw_materials/_form";
export default {
    props: ["propGoods", "propRawMaterial","propLinkRawMaterial"],
    components: {
        formLinkRawMaterial,
    },
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        emitExit() {
            this.dialog = false;
        },
        emitFetchGoods(){
            this.$emit("emitFetchGoods")
        }
    },
};
</script>

<style></style>
