<template>
    <div>
        <v-dialog persistent v-model="dialog" fullscreen>
            <template v-slot:activator="{ on }">
                <v-btn
                    block
                    x-large
                    class="mb-3 info"
                    v-on="on"
                    @click="get_lottery()"
                >
                    ลุ้นเลขท้าย 2 ตัว
                </v-btn>
            </template>
            <v-card>
                <v-card-title class="text-h5 font-weight-bold">
                    ชิงรางวัลสะสม {{ lottery.apotp }} คะแนน
                    <v-spacer></v-spacer>
                    <v-btn icon fab x-small @click="clickExit()">
                        <v-icon color="error">close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-subtitle class="error--text pt-2 pb-0 font-weight-bold"
                    >ใช้ 1 คะแนน | สูงสุด 5 เลข/งวด</v-card-subtitle
                >

                <v-card-title >
                    <div v-for="lottery in lotterys" :key="lottery.id">
                        <v-btn
                            v-if="match_me(lottery)"
                            fab
                            elevation="0"
                            class="ma-1 deep-orange white--text"
                            >{{ lottery.text }}</v-btn
                        >

                        <v-btn
                            v-else
                            fab
                            elevation="0"
                            @click="save_lottery(lottery)"
                            class="ma-1 success"
                            :disabled="match_lottery(lottery)"
                            >{{ lottery.text }}</v-btn
                        >
                    </div>
                </v-card-title>
                <v-card-actions> </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            dialog: false,
            lotterys: [],
            lottery: {},
        };
    },
    methods: {
        match_me(v) {
            if (
                this.lottery.lottery_me.find((e) => {
                    return e == v.text;
                })
            ) {
                return true;
            }

            return false;
        },
        clickExit() {
            this.dialog = false;
            this.$emit("emitExit");
        },
        save_lottery(v) {
            // this.lottery.reserve_lotterys.push(v.text);
            // this.lotterys[v.id].match = true;

            if (this.lottery.lottery_me.length >= 5) {
                this.$toast.error("คุณลงทะเบียนครบ 5 เลขแล้ว");
                return;
            }

            this.$swal({
                icon: "info",
                title: `เลขนำโชค ${v.text}`,
                text: `งวดวันที่ ${this.lottery.date.date_th}`,
                // footer: `ใช้ 5 คะแนน สำหรับลงทะเบียน`,
                showCancelButton: true,
                confirmButtonText: "ลงทะเบียน",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "ออก",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.register(v.text);
                }
            });
        },
        async register(v) {
            const payload = {
                lucky_number: v,
            };
            await axios
                .post(
                    `/api/v1/guest/lottery/${this.profile.customer_id}/${this.lottery.date.id}/register`,
                    payload
                )
                .then((result) => {
                    let loader = this.$loading.show();
                    if (result.data.status == "success") {
                        this.$toast.success(result.data.message);
                    } else {
                        this.$toast.error(result.data.message);
                    }
                    this.get_lottery();
                    loader.hide();
                });
        },
        async get_lottery() {
            let loader = this.$loading.show();
            const status = await axios
                .get(
                    `/api/v1/guest/lottery/${this.profile.customer_id}/get_period`
                )
                .then((res) => {
                    this.lottery = res.data;
                    return true;
                })
                .catch((err) => {
                    this.$swal({
                        icon: "error",
                        title: `ไม่มีงวดรางวัลในขณะนี้`,
                        text: `โปรดลองอีกครั้งภายหลัง`,
                        // footer: `ใช้ 5 คะแนน สำหรับลงทะเบียน`,
                        confirmButtonText: "รับทราบ",
                        confirmButtonColor: "#3085d6",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.dialog = false;
                        }
                    });

                    return false;
                });
            loader.hide();
            if (!status) {
                return;
            }

            this.lotterys = [];

            // if()

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
    computed: {
        ...mapGetters({
            profile: "profilePsid/profile",
        }),
    },
};
</script>

<style></style>
