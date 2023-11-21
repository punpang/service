<template>
    <v-row>
        <v-col class="pa-0" cols="10" md="8">
            <v-text-field
                outlined
                hide-details
                dense
                label="ใส่รหัสคูปอง"
                v-model="useConpon.code"
            ></v-text-field>
        </v-col>
        <v-col class="pa-0 pl-2" cols="2" md="4">
            <v-btn
                class="success"
                elevation="0"
                block
                height="100%"
                small
                @click="clickUseCoupon()"
                :disabled="useConpon.code == ''"
                >ใช้</v-btn
            >
        </v-col>
    </v-row>
</template>

<script>
// import { mapGetters } from "vuex";
export default {
    props: ["propOrder"],
    data() {
        return {
            useConpon: {
                code: "",
                order_id: "",
            },
        };
    },
    methods: {
        async clickUseCoupon() {
            if (this.useConpon.code == "") {
                this.$toast.error("โปรดกรอดรหัสคูปอง");
                return;
            }
            // this.useConpon.order_id = this.propOrderID;
            const payload = {
                code: this.useConpon.code,
                order_id: this.propOrder.id,
            };

            await this.$store
                .dispatch("couponsUsed/useCoupon", payload)
                .then((response) => {
                    this.$swal({
                        toast: true,
                        icon: response.data.icon,
                        title: response.data.title,
                        allowOutsideClick: false,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        position: "bottom",
                    });
                })
                .catch((err) => {});
        },
        reset() {
            this.useConpon = {
                code: "",
                order_id: "",
                customer_id: "",
            };
        },
    },
    // computed: {
    //     ...mapGetters({
    //         // order: "orderIndex/order",
    //     }),
    // },
};
</script>

<style></style>
