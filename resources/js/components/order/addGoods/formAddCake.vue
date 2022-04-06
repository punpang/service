<template>
    <div>
        <v-form lazy-validation ref="form">
            <v-text-field
                :label="msg.text.message"
                outlined
                hide-details
                class="mb-3"
                v-model="propForm.message"
                :rules="rules.message"
            ></v-text-field>
            <v-textarea
                :label="msg.text.detail"
                outlined
                hide-details
                class="mb-3"
                v-model="propForm.detail"
                :rules="rules.detail"
            ></v-textarea>
        </v-form>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propForm"],
    computed: {
        ...mapGetters({
            msg: "orderProductCake/msg",
            rules: "orderProductCake/rules",
        }),
    },
};
</script>
