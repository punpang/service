<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn
                    v-on="on"
                    class="deep-orange d-none d-sm-flex"
                    dark
                    :small="propSmall"
                    @click="clickStart()"
                >
                    <v-icon left> edit</v-icon>
                    แก้ไขข้อความ
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
                    <v-icon> edit</v-icon>
                </v-btn>
            </template>
            <formMessage
                @emitExit="emitExit"
                :propMessage="propMessage"
                :propUpdate="propUpdate"
            ></formMessage>
        </v-dialog>
    </div>
</template>

<script>
import formMessage from "@/js/components/sms/_form";
export default {
    props: ["propMessage", "propUpdate","propSmall"],
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
        },
    },
};
</script>

<style></style>
