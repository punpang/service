<template>
    <div>
        <v-card outlined class="mb-3">
            <v-card-title class="text-h6">
                คุณ {{ profile.customer.name }} <v-spacer></v-spacer>
                {{ profile.customer.sum_diff_score }} คะแนน
            </v-card-title>
        </v-card>

        <v-btn block x-large class="mb-3 error"> คูปองของฉัน </v-btn>
        <v-btn block x-large class="mb-3 warning"> ใช้แทนเงินสด </v-btn>
        <v-btn block x-large class="mb-3 success"> แลกของรางวัล </v-btn>
        <lottery @emitExit="emitExit()"></lottery>
        <v-divider></v-divider>
    </div>
</template>

<script>
import lottery from "@/js/pages/guest/profile_psid/lotterys/register";
import { mapGetters } from "vuex";
export default {
    components: { lottery },
    data() {
        return {
            showFormAll: false,
        };
    },
    methods: {
        emitExit() {
            this.start();
        },
        async start() {
            let loader = this.$loading.show();
            const fullPathSplit = this.$route.fullPath.split("?");
            await this.$store
                .dispatch("profilePsid/get_profile", {
                    query: fullPathSplit[1],
                })
                .then((result) => {
                    console.log(result.status);
                    this.showFormAll = true;
                })
                .catch((err) => {});
            loader.hide();
        },
    },
    async mounted() {
        await this.start();
    },
    computed: {
        ...mapGetters({
            profile: "profilePsid/profile",
        }),
    },
};
</script>

<style></style>
