<template>
    <div>
        <v-dialog persistent width="500" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="deep-orange d-none d-sm-flex" dark>
                    <v-icon left> add</v-icon>
                    สร้างวัตถุดิบ
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
            <formRawMaterial @emitExit="emitExit"></formRawMaterial>
        </v-dialog>
    </div>
</template>

<script>
import formRawMaterial from "@/js/components/pos/goods/raw_material/_form.vue";
export default {
    components: { formRawMaterial },
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
};
</script>

<style></style>
