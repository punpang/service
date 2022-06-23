<template>
    <div>
        <v-textarea
            :label="msg.text.detail"
            outlined
            hide-details
            class="mb-3"
            v-model="propDetail"
            @click="clickDetail()"
            :rules="rules.detail"
        ></v-textarea>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propDetail"],
    methods: {
        clickDetail() {
            if (this.propDetail == "-") {
                this.propDetail = "";
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
