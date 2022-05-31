<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn v-on="on" class="warning mr-2" @click="start()">
                    <v-icon left>
                        {{ msg.icon.edit }}
                    </v-icon>
                    {{ msg.text.edit }}</v-btn
                >
            </template>
            <v-card>
                <v-card-title>
                    <h3>
                        {{ msg.text.edit }}
                    </h3>
                    <v-spacer></v-spacer>
                    <v-btn fab icon x-small color="error" @click="close()">
                        <v-icon>close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <h5 class="mb-4">
                        <strong v-if="propProduct.am1">
                            {{ propProduct.am1.m1 }} :
                            {{ propProduct.am2.m2 }} :
                            {{ propProduct.am3.m3 }} :
                            {{ propProduct.am4.m4 }}
                        </strong>
                    </h5>
                    <v-text-field
                        :label="msg.text.price"
                        v-model="propProduct.price"
                        outlined
                        hide-details
                        :rules="rules.price"
                        type="number"
                        pattern="\d*"
                        class="mb-3"
                    ></v-text-field>
                    <uploadImageProduct
                        :propProduct="propProduct"
                        :propISRemove="isRemove"
                        @emitSuccessUploadImageProduct="
                            emitSuccessUploadImageProduct
                        "
                    ></uploadImageProduct>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        :class="isRemove ? 'warning' : 'error'"
                        @click="isRemove = !isRemove"
                        v-if="propProduct.google_image"
                    >
                        <v-icon left>
                            {{ isRemove ? "refresh" : "delete" }}
                        </v-icon>
                        {{ isRemove ? "เรียกคืน" : "ลบรูปภาพ" }}
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="error" @click="close()">
                        <v-icon left>
                            {{ msg.icon.exit }}
                        </v-icon>
                        {{ msg.text.exit }}
                    </v-btn>
                    <v-btn class="success" @click="save()">
                        <v-icon left>
                            {{ msg.icon.save }}
                        </v-icon>
                        {{ msg.text.save }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import uploadImageProduct from "@/js/components/order/product/select/uploadImageProduct";
export default {
    props: ["propProduct"],
    data() {
        return {
            dialog: false,
            price_old: 0,
            isRemove: false,
        };
    },
    components: {
        uploadImageProduct,
    },
    methods: {
        emitSuccessUploadImageProduct() {
            this.isRemove = false;
        },
        async save() {
            if (!this.propProduct.id || !this.propProduct.price) return;
            let loader = this.$loading.show();
            const result = await this.$store.dispatch(
                "orderProductCake/editPrice",
                this.propProduct
            );

            if (result == 200) {
                this.$swal({
                    title: this.msg.text.editSuccess,
                    icon: "success",
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 2000,
                    //   confirmButtonText: `เรียบร้อย`,
                });
                this.dialog = false;
            } else {
                this.$swal({
                    title: this.msg.text.editError,
                    icon: "error",
                    allowOutsideClick: false,
                    confirmButtonText: `เรียบร้อย`,
                });
            }
            loader.hide();
        },
        start() {
            this.price_old = this.propProduct.price;
        },
        close() {
            this.propProduct.price = this.price_old;
            this.dialog = false;
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
