<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn icon fab x-small v-on="on">
                    <v-icon>more_vert</v-icon>
                </v-btn>
            </template>
            <formRawMaterial :propRawMaterial="propRawMaterial" @emitExit="emitExit"></formRawMaterial>
        </v-dialog>
    </div>
</template>

<script>
import formRawMaterial from "@/js/components/pos/goods/raw_material/_form.vue";
export default {
    props: ["propRawMaterial"],
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
        formRawMaterial,
    },
};
</script>

<style></style>
