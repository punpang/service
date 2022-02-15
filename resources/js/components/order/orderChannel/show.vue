<template>
    <div>
        <v-card>
            <v-card-title>
                <v-icon left>
                    {{ msg.icon.titleMain }}
                </v-icon>
                <h3>
                    {{ msg.text.titleMain }}
                </h3>
            </v-card-title>
            <v-card-text>
                <v-select
                    :prepend-icon="msg.icon.selectChannel"
                    :items="fetchChannel"
                    item-text="title"
                    item-value="id"
                    v-model="temp.temp.channel"
                    outlined
                    :rules="rules.channel"
                    hide-details
                    class="mb-4"
                    :label="msg.text.selectChannel"
                ></v-select>
                <v-alert v-if="propDataSuccess" type="success"
                    >ข้อมูลครบถ้วน</v-alert
                >
                <v-alert v-else type="warning">ตรวจสอบข้อมูล</v-alert>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    props: ["propDataSuccess"],
    data() {
        return {};
    },
    methods: {},
    async mounted() {
        let loader = this.$loading.show();
        await this.$store.dispatch("orderChannel/fetchUse");
        loader.hide();
    },
    computed: {
        ...mapGetters({
            msg: "orderChannel/msg",
            fetchChannel: "orderChannel/fetchUse",
            rules: "orderChannel/rules",
            temp: "orderTemp/temp",
        }),
    },
};
</script>
