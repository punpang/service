<template>
    <div>
        <v-form lazy-validation ref="formSearch">
            <v-row>
                <v-col cols="9" md="9" class="pr-1">
                    <v-text-field
                        :label="msgCustomer.phoneNumberCustomer"
                        outlined
                        v-model="phone_number"
                        autofocus
                        pattern="\d*"
                        type="number"
                        :rules="rules.phone_number"
                    ></v-text-field>
                </v-col>
                <v-col cols="3" md="3" class="text-right pl-1">
                    <v-btn fab outlined color="info" @click="clickSearch()">
                        <v-icon>
                            {{ msgCustomer.iconSearch }}
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
            <cardSearchTrue v-if="getSearch"></cardSearchTrue>
            <v-card-actions v-if="getSearch" class="text-right">
                <v-btn
                    class="success"
                    :disabled="getSearch == ''"
                    x-large
                    @click="clickSave()"
                >
                    <v-icon left>
                        {{ msgCustomer.iconSelect }}
                    </v-icon>
                    {{ msgCustomer.selectCustomerText }}
                </v-btn>
                <v-btn class="error" x-large @click="clickReset()">
                    <v-icon left>
                        {{ msgCustomer.icon.refresh }}
                    </v-icon>
                    {{ msgCustomer.text.refresh }}
                </v-btn>
            </v-card-actions>
        </v-form>
    </div>
</template>

<script>
import cardSearchTrue from "@/js/components/order/customer/cardSearch/cardSearchTrue";
import { mapGetters } from "vuex";
export default {
    components: { cardSearchTrue },
    data() {
        return {
            phone_number: "",
        };
    },
    methods: {
        async clickSearch() {
            if (this.$refs.formSearch.validate()) {
                let loader = this.$loading.show();
                await this.$store.dispatch(
                    "orderCustomer/getSearch",
                    this.phone_number
                );

                this.$emit("emitSearch", this.phone_number);
                loader.hide();
            }
        },
        async clickSave() {
            await this.$store.dispatch("orderTemp/fetch", {
                customer: this.getSearch,
            });

            if (this.temp.id) {
                await this.$store.dispatch("orderDetailTemp/fetch", {
                    order_temp: this.temp,
                });
                this.$emit("emitCountSetTemp");
            }

            this.phone_number = "";
            this.$emit("emitSave");
        },
        clickReset() {
            this.phone_number = "";
            this.$store.commit("orderCustomer/resetCustomer");
            this.$emit("emitReset");
        },
    },
    computed: {
        ...mapGetters({
            getSearch: "orderCustomer/getSearch",
            msgCustomer: "orderCustomer/messages",
            rules: "orderCustomer/rules",
            temps: "orderDetailTemp/temps",
            temp: "orderTemp/temp",
        }),
    },
};
</script>

<style></style>
