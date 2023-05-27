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
        <v-btn block x-large class="mb-3 info"> ลุ้นเลขท้าย 2 ตัว </v-btn>
        <v-divider></v-divider>

        <v-btn
            v-for="lottery in lotterys"
            fab
            elevation="0"
            @click="save_lottery(lottery)"
            :class="match_lottery(lottery) ? 'error' : 'success'"
            class="ma-1 ml-3"
            :disabled="match_lottery(lottery)"
            :key="lottery.id"
            >{{ lottery.text }}</v-btn
        >

        {{ lottery }}
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            showFormAll: false,
            lotterys: [],
            lottery: {
                date_lottery: "16/01/2565",
                reserve_lotterys: [
                    "05",
                    "08",
                    "09",
                    "10",
                    "00",
                    "11",
                    "12",
                    "95",
                    "47",
                    "58",
                    "53",
                    "78",
                    "32",
                    "02",
                    "65",
                    "99",
                    "98",
                    "42",
                    "50",
                    "39",
                    "36",
                    "33",
                    "60",
                    "89",
                ],
            },
        };
    },
    methods: {
        save_lottery(v) {
            this.lottery.reserve_lotterys.push(v.text);
            this.lotterys[v.id].match = true;
        },
        get_lottery() {
            this.lotterys = [];
            for (let i = 0; i < 100; i++) {
                if (i < 10) {
                    this.lotterys.push({
                        id: i,
                        text: "0" + i,
                        match: false,
                    });
                } else {
                    this.lotterys.push({
                        id: i,
                        text: "" + i,
                        match: false,
                    });
                }

                this.lotterys[i].match = this.match_lottery(this.lotterys[i]);
            }
        },
        match_lottery(v) {
            if (
                this.lottery.reserve_lotterys.find((e) => {
                    return e == v.text;
                })
            ) {
                return true;
            }

            return false;
            //
        },
    },
    async mounted() {
        const fullPathSplit = this.$route.fullPath.split("?");
        this.get_lottery();
        console.log(fullPathSplit[1]);
        // const result = await this.$store.dispatch(
        //         "facebook/register_member",
        //         payload
        //     );
        await this.$store
            .dispatch("profilePsid/get_profile", {
                query: fullPathSplit[1],
            })
            .then((result) => {
                console.log(result.status);
                this.showFormAll = true;
            })
            .catch((err) => {});
    },
    computed: {
        ...mapGetters({
            profile: "profilePsid/profile",
        }),
    },
};
</script>

<style></style>
