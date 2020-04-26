<template>
    <div>
        <v-dialog v-model="dialog" persistent width="700">
            <template v-slot:activator="{ on }">
                <v-list-item
                    @click="start"
                    v-on="on"
                    class="teal darken-1"
                    v-if="action.method == 'create'"
                >
                    <v-list-item-icon>
                        <v-icon>{{ action.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{
                            action.title
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-btn
                    color="warning"
                    class="mr-2 d-none d-sm-flex"
                    v-if="action.method == 'update'"
                    v-on="on"
                    @click="start"
                >
                    <v-icon left>edit</v-icon>
                    {{ action.title }}
                </v-btn>
                <v-btn
                    color="warning"
                    class="mr-2 d-flex d-sm-none"
                    v-if="action.method == 'update'"
                    fab
                    small
                    v-on="on"
                    @click="start"
                >
                    <v-icon>edit</v-icon>
                    <!-- แก้ไขข้อมูล -->
                </v-btn>
            </template>
            <v-card color="#121212">
                <v-card-title>
                    {{ action.title }}
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
                                            v-if="product.id >= 1"
                                            width="auto"
                                            :src="
                                                'https://drive.google.com/thumbnail?id=' +
                                                    product.product_image
                                                        .src_name
                                            "
                                        ></v-img>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="8"
                                        v-if="product.id >= 1"
                                    >
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
                                                    label="ราคา/หน่วย"
                                                    outlined
                                                    v-currency
                                                    placeholder="กรุณาเลือกสินค้า"
                                                    readonly
                                                    v-model="form.price"
                                                    :rules="Rules.price"
                                                    suffix="บาท"
                                                    hide-details
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <v-text-field
                                                    label="จำนวน"
                                                    outlined
                                                    type="number"
                                                    pattern="\d*"
                                                    placeholder="กรุณาเลือกสินค้า"
                                                    v-model="form.quantity"
                                                    :rules="Rules.quantity"
                                                    suffix="หน่วย"
                                                    hide-details
                                                    @click="clickQuantity"
                                                    @change="
                                                        changeQuantity(
                                                            form.quantity,
                                                            form.price
                                                        )
                                                    "
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="6" md="6">
                                                <v-text-field
                                                    label="ราคารวม"
                                                    outlined
                                                    placeholder="กรุณาเลือกสินค้า"
                                                    readonly
                                                    v-model="form.sum_price"
                                                    :rules="Rules.sum_price"
                                                    suffix="บาท"
                                                    hide-details
                                                    v-currency
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
                                                        tag
                                                            .product_category_sub_use_only
                                                            .product_category
                                                            .name
                                                    "
                                                    outlined
                                                    readonly
                                                    hide-details
                                                    v-model="
                                                        tag
                                                            .product_category_sub_use_only
                                                            .name
                                                    "
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <v-row class="px-4">
                                                    <v-checkbox
                                                        v-model="
                                                            form.write_status
                                                        "
                                                        @change="
                                                            changeWriteStatus
                                                        "
                                                        hide-details
                                                        class="shrink mr-2 mt-0"
                                                    ></v-checkbox>
                                                    <v-textarea
                                                        label="เขียนข้อความ"
                                                        hide-details
                                                        outlined
                                                        rows="1"
                                                        v-model="form.write"
                                                        :rules="Rules.write"
                                                        :readonly="
                                                            form.write_status ==
                                                                false
                                                        "
                                                    ></v-textarea>
                                                </v-row>
                                            </v-col>
                                            <v-col cols="12" md="12">
                                                <v-row class="px-4">
                                                    <v-checkbox
                                                        v-model="
                                                            form.note_status
                                                        "
                                                        @change="
                                                            changeNoteStatus
                                                        "
                                                        hide-details
                                                        class="shrink mr-2 mt-0"
                                                    ></v-checkbox>
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
                                                </v-row>
                                            </v-col>

                                            <v-col cols="12" md="12">
                                                <v-row class="px-4">
                                                    <v-checkbox
                                                        v-model="
                                                            form.upload_image_status
                                                        "
                                                        hide-details
                                                        label="ส่งลิงก์อัปโหลดรูปภาพ"
                                                        class="ma-0 pa-0"
                                                    ></v-checkbox>
                                                </v-row>
                                            </v-col>

                                            <v-col cols="12" md="12">
                                                <v-row class="px-4">
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
                                    <v-col v-else cols="12" md="8">
                                        <v-alert
                                            color="blue-grey"
                                            dark
                                            dense
                                            prominent
                                        >
                                            กรุณาเลือกสินค้าก่อน "เลือกสินค้า"
                                        </v-alert>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-form>
                </v-card-text>
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
    props: ["order", "action", "detail"],
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
            response: {},
            product: {
                id: 0,
                product_image: {
                    src_name: ""
                }
            },
            priceProduct: 0,
            form: {},
            Rules: {
                order_id: [v => !!v],
                product_id: [v => !!v],
                write: [v => !!v],
                note: [v => !!v],
                price: [v => !!v],
                quantity: [v => !!v, v => v > 0],
                sum_price: [v => !!v]
            }
        };
    },
    methods: {
        async save() {
            this.overlay = true;
            if (this.$refs.form.validate()) {
                if (this.action.method == "create") {
                    this.response = await this.$store.dispatch(
                        "orderDetail/store",
                        this.form
                    );
                } else if (this.action.method == "update") {
                    this.response = await this.$store.dispatch(
                        "orderDetail/update",
                        this.form
                    );
                }

                if (this.response.status == 200) {
                    this.snackbar = this.$store.getters["snackbar/success"];
                    this.out();
                } else {
                    this.snackbar = this.$store.getters["snackbar/error"];
                }
            } else {
                this.snackbar = this.$store.getters["snackbar/error"];
            }
            this.overlay = false;
        },
        changeQuantity(q, p) {
            this.form.sum_price = q * p;
        },
        clickQuantity() {
            this.form.quantity = "";
        },
        async start() {
            if (this.action.method == "create") {
                this.form = {
                    order_id: this.order.id,
                    product_id: "",
                    write_status: true,
                    write: "",
                    note_status: true,
                    upload_image_status: false,
                    note: "",
                    price: "",
                    quantity: "1",
                    sum_price: "",
                    status: true
                };
                this.product = {
                    id: 0,
                    product_image: {
                        src_name: ""
                    },
                    price_normal: 0,
                    price_special_status: 0,
                    price_special: 0
                };
            } else if (this.action.method == "update") {
                this.form = this.detail;
                this.product = this.detail.product;
            }
        },
        out() {
            this.dialog = false;
            this.overlay = false;
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
            this.changeQuantity(this.form.quantity, v.price);
        }
    }
};
</script>

<style></style>
