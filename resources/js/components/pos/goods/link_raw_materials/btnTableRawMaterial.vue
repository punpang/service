<template>
    <div>
        <v-dialog persistent width="700" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="deep-orange d-none d-sm-flex" dark>
                    <v-icon left> add</v-icon>
                    เลือกวัตถุดิบ
                </v-btn>

                <v-btn
                    icon
                    fab
                    small
                    v-on="on"
                    class="deep-orange d-flex d-sm-none"
                    dark
                >
                    <v-icon> add</v-icon>
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h6 white--text warning">
                    เลือกวัตถุดิบ
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="emitExit()">
                        <v-icon color="white">close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <tableRawMaterial
                        :propGoods="propGoods"
                        @emitExit="emitExit"
                        @emitFetchGoods="emitFetchGoods"
                    ></tableRawMaterial>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import tableRawMaterial from "@/js/components/pos/goods/raw_material/table";
export default {
    props: ["propGoods"],
    components: { tableRawMaterial },
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
        emitFetchGoods() {
            this.$emit("emitFetchGoods");
        },
    },
    computed: {},
};
</script>

<style></style>
