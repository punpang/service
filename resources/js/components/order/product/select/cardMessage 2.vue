<template>
    <div>
        <v-text-field
            :label="msg.text.message"
            outlined
            hide-details
            class="mb-3"
            v-model="propMessage"
            @click="clickMessage()"
            :rules="rules.message"
        ></v-text-field>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propMessage"],
    methods: {
        clickMessage() {
            if (this.propMessage == "-") {
                this.propMessage = "";
            }
            
        },
    },
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
        }),
    },
};
</script>
