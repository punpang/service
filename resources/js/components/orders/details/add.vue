<template>
    <div>
        <v-dialog v-model="dialog" persistent width="700">
            <template v-slot:activator="{ on }">
                <v-btn
                    block
                    color="primary"
                    v-on="on"
                    class="mb-2"
                    @click="start"
                    >เพิ่มสินค้าใหม่</v-btn
                >
            </template>
            <v-card color="#121212">
                <v-card-title>
                    เพิ่มสินค้าใหม่
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" lazy-validation>
                        <v-card>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <selectProduct
                                            @emitSelectProduct="
                                                emitSelectProduct
                                            "
                                        ></selectProduct>
                                        <v-divider></v-divider>
                                        <v-img
                                            v-show="product.id >= 1"
                                            width="auto"
                                            :src="
                                                'https://drive.google.com/thumbnail?id=' +
                                                    product.product_image
                                                        .src_name
                                            "
                                        ></v-img>
                                    </v-col>
                                    <v-col cols="12" md="8">
                                        <v-row>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="pt-0"
                                            >
                                                <v-text-field
                                                    label="ชื่อสินค้า"
                                                    outlined
                                                    placeholder="คลิกที่นี่เพื่อเลือกสินค้า"
                                                    readonly
                                                    v-model="product.name"
                                                    hide-details
                                                ></v-text-field>
                                            </v-col>

                                            <v-col cols="12" md="12">
                                                <v-text-field
                                                    label="ราคา"
                                                    outlined
                                                    placeholder="กรุณาเลือกสินค้า"
                                                    readonly
                                                    v-model="form.price"
                                                    :rules="Rules.price"
                                                    suffix="บาท"
                                                    hide-details
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="6"
                                                v-for="tag in product.product_tag_use_only"
                                                :key="tag.id"
                                            >
                                                <v-text-field
                                                    :label="
                                                        tag.product_category_sub
                                                            .product_category
                                                            .name
                                                    "
                                                    outlined
                                                    readonly
                                                    hide-details
                                                    v-model="
                                                        tag.product_category_sub
                                                            .name
                                                    "
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <v-container class="py-0">
                                                    <v-row>
                                                        <v-text-field
                                                            label="เขียนข้อความ"
                                                            hide-details
                                                            outlined
                                                            v-model="form.write"
                                                            :rules="Rules.write"
                                                            :readonly="
                                                                form.write_status ==
                                                                    false
                                                            "
                                                        ></v-text-field>
                                                        <v-switch
                                                            v-model="
                                                                form.write_status
                                                            "
                                                            inset
                                                            hide-details
                                                            class="ml-3"
                                                            @change="
                                                                changeWriteStatus
                                                            "
                                                        ></v-switch>
                                                    </v-row>
                                                </v-container>
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <v-container class="py-0">
                                                    <v-row>
                                                        <v-textarea
                                                            label="เพิ่มเติม"
                                                            hide-details
                                                            outlined
                                                            rows="2"
                                                            v-model="form.note"
                                                            :rules="Rules.note"
                                                            :readonly="
                                                                form.note_status ==
                                                                    false
                                                            "
                                                        ></v-textarea>
                                                        <v-switch
                                                            v-model="
                                                                form.note_status
                                                            "
                                                            inset
                                                            hide-details
                                                            class="ml-3"
                                                            @change="
                                                                changeNoteStatus
                                                            "
                                                        ></v-switch>
                                                    </v-row>
                                                </v-container>
                                            </v-col>

                                            <v-col cols="12" md="12">
                                                <v-container class="py-0">
                                                    <v-row>
                                                        <v-btn
                                                            @click="save"
                                                            color="success"
                                                            class="mr-2"
                                                        >
                                                            <v-icon left
                                                                >save</v-icon
                                                            >
                                                            เรียบร้อย</v-btn
                                                        >
                                                        <v-btn
                                                            color="error"
                                                            @click="out"
                                                        >
                                                            <v-icon left
                                                                >exit_to_app</v-icon
                                                            >
                                                            ออก</v-btn
                                                        >
                                                    </v-row>
                                                </v-container>
                                            </v-col>
                                            <div v-show="1 == 0">
                                                <v-text-field
                                                    label="product id"
                                                    placeholder="กรุณาเลือกสินค้า"
                                                    v-model="form.product_id"
                                                    :rules="Rules.product_id"
                                                    hide-details
                                                ></v-text-field>
                                                <v-text-field
                                                    label="order id"
                                                    placeholder="กรุณาเลือกสินค้า"
                                                    v-model="form.order_id"
                                                    :rules="Rules.order_id"
                                                    hide-details
                                                ></v-text-field>
                                            </div>
                                        </v-row>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-form>
                </v-card-text>

                {{ form }}
            </v-card>
            <processingProduct
                :product="product"
                @emitProcessed="emitProcessed"
            ></processingProduct>

            <overlay :overlay="overlay"></overlay>
        </v-dialog>
        <snackbarRight :snackbar="snackbar"></snackbarRight>
    </div>
</template>

<script>
import selectProduct from "@/js/components/orders/details/selectProduct";
import tagsProduct from "@/js/components/orders/details/tagsProduct";
import processingProduct from "@/js/components/orders/details/processingProduct";
import snackbarRight from "@/js/layouts/snackbarRight";
import overlay from "@/js/layouts/overlay";

export default {
    props: ["order"],
    components: {
        selectProduct,
        tagsProduct,
        processingProduct,
        snackbarRight,
        overlay
    },
    data() {
        return {
            dialog: false,
            snackbar: {
                status: false
            },
            overlay: false,
            product: {},
            priceProduct: 0,
            form: {},
            Rules: {
                order_id: [v => !!v],
                product_id: [v => !!v],
                write: [v => !!v],
                note: [v => !!v],
                price: [v => !!v, v => v > 0]
            }
        };
    },
    methods: {
        async save() {
            this.overlay = true;
            if (this.$refs.form.validate()) {
                const res = await this.$store.dispatch(
                    "orderDetail/store",
                    this.form
                );
                if (res.status == 200) {
                    this.snackbar = {
                        status: true,
                        color: "success",
                        text: "ลงสินค้าสำหรับรายการสั่งซื้อ #" + this.order.id
                    };
                    this.out();
                } else {
                    this.snackbar = {
                        status: true,
                        color: "warning",
                        text: this.$store.getters["main/snackbarError"]
                    };
                }
            } else {
                this.snackbar = {
                    status: true,
                    color: "warning",
                    text: this.$store.getters["main/snackbarError"]
                };
            }
            this.overlay = false;
        },
        async start() {
            await this.form = {
                order_id: this.order.id,
                product_id: "",
                write_status: true,
                write: "",
                note_status: true,
                note: "",
                price: "",
                status: true
            };
            await this.product = {
                id: 0,
                product_image: {
                    src_name: ""
                },
                price_normal: 0,
                price_special_status: 0,
                price_special: 0
            };
        },
        out() {
            this.dialog = false;
        },
        emitSelectProduct(item) {
            this.product = item;
            this.form.product_id = item.id;
        },
        changeWriteStatus(v) {
            if (v == false) {
                if (this.form.write == "") {
                    this.form.write = "no message";
                }
            } else {
                if (this.form.write == "no message") {
                    this.form.write = "";
                }
            }
        },
        changeNoteStatus(v) {
            if (v == false) {
                if (this.form.note == "") {
                    this.form.note = "no note";
                }
            } else {
                if (this.form.note == "no note") {
                    this.form.note = "";
                }
            }
        },
        emitProcessed(v) {
            this.form.price = v.price;
        }
    }
};
</script>

<style></style>
