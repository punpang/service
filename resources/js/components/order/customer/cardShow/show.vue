<template>
    <div>
        {{ propCustomer }}
        <v-card>
            <v-card-title>
                <v-icon left>
                    {{ msgCustomer.icon.dataCustomer }}
                </v-icon>
                <h3>
                    {{ msgCustomer.text.dataCustomer }}
                </h3>
                <v-spacer></v-spacer>
                <customerSearch
                    @emitCountSetTemp="emitCountSetTemp"
                ></customerSearch>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    :label="msgCustomer.text.nameCustomer"
                    :prepend-icon="msgCustomer.icon.dataCustomer"
                    outlined
                    v-model="customer.name"
                    class="mb-4"
                    readonly
                    hide-details
                ></v-text-field>
                <v-text-field
                    :label="msgCustomer.text.phoneNumberCustomer"
                    :prepend-icon="msgCustomer.icon.phone"
                    outlined
                    v-model="customer.tel"
                    class="mb-4"
                    readonly
                    hide-details
                ></v-text-field>
                <!-- <v-row>
          <v-col cols="6" md="6">
            {{ msgCustomer.text.nameCustomer }}
          </v-col>
          <v-col cols="6" md="6" class="text-right">
            {{ customer.name }}
          </v-col>
          <v-col cols="6" md="6">
            {{ msgCustomer.text.phoneNumberCustomer }}
          </v-col>
          <v-col cols="6" md="6" class="text-right">
            {{ customer.tel }}
          </v-col>
        </v-row> -->
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import customerSearch from "@/js/components/order/customer/search";

export default {
    props: ["propCustomer"],
    components: { customerSearch },
    data() {
        return {
            // customer: this.propCustomer,
        };
    },
    methods: {
        emitCountSetTemp() {
            this.$emit("emitCountSetTemp");
        },
    },
    computed: {
        ...mapGetters({
            msgCustomer: "orderCustomer/messages",
            customer: "orderCustomer/getSearch",
        }),
    },
};
</script>

<style></style>
