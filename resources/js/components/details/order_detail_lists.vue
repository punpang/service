<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="details"
            hide-default-footer
            :search="propSearch"
            :sort-by="['a_order.time_get']"
            :items-per-page="-1"
        >
            <template v-slot:item.image_goods="{ item }">
                <imageThumbnailFullPathSizeFree
                    v-if="
                        item.a_price.google_image ||
                        item.product_prototypes.length > 0
                    "
                    :path="
                        item.product_prototypes.length > 0
                            ? item.product_prototypes[0]
                            : item.a_price
                    "
                    :size="80"
                ></imageThumbnailFullPathSizeFree>
            </template>
            <template v-slot:item.a_price.name_goods="{ item }">
                <div class="py-3">
                    <p class="mb-0 font-weight-black text-subtitle-2">
                        {{ item.a_price.name_goods }}
                    </p>

                    <p
                        v-for="a in item.add_ons"
                        :key="a"
                        class="mb-1 text-body-2"
                    >
                        + {{ a.product_add_on.goods_add_on.name }}
                    </p>

                    <div
                        v-if="item.message != '-'"
                        class="d-flex justify-lg-start justify-md-start justify-sm-start justify-xl-start justify-end"
                    >
                        <p class="mb-1 text-caption font-weight-black">
                            ข้อความ
                        </p>
                        <p class="mb-1 text-caption">: {{ item.message }}</p>
                    </div>

                    <p
                        class="mb-1 text-caption info--text font-weight-black"
                        v-if="item.detail != '-'"
                    >
                        *{{ item.detail }}*
                    </p>

                    <!-- <v-btn class="info" x-small rounded> ต้นแบบสินค้า </v-btn> -->
                    <btnPrototypeImage
                        :propPath="
                            item.product_prototypes[0].google_image.src_name
                        "
                        v-if="item.product_prototypes.length > 0"
                    ></btnPrototypeImage>

                    <v-btn
                        class="pink accent-2"
                        x-small
                        rounded
                        dark
                        v-if="item.add_ons.length > 0"
                    >
                        ตกแต่งเพิ่มเติม
                    </v-btn>

                    <!-- <v-btn class="indigo accent-3" x-small rounded dark>
                        ลูกบอล/ล้อม/ซ่อนเงิน
                    </v-btn> -->

                    <v-btn
                        class="cyan darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.a_order.order_delivery_service"
                    >
                        บริการจัดส่ง
                    </v-btn>

                    <v-btn
                        class="purple darken-3"
                        x-small
                        rounded
                        dark
                        v-if="item.is_take_a_photo"
                    >
                        ถ่ายรูปสินค้า
                    </v-btn>

                    <v-btn
                        class="lime darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.status_upload_images_from_customer"
                    >
                        รูปภาพลูกค้า
                    </v-btn>

                    <v-btn
                        class="yellow accent-4"
                        x-small
                        rounded
                        v-if="item.money_services.length > 0"
                    >
                        บริการเกี่ยวกับเงิน
                    </v-btn>

                    <v-btn :class="item.a_order.a_status.class" x-small rounded>
                        {{ item.a_order.a_status.status }}
                    </v-btn>
                </div>
            </template>
            <!-- <template v-slot:item.tags="{ item }">
                <div class="py-3">
                    <v-btn
                        class="info"
                        x-small
                        rounded
                        v-if="item.product_prototypes.length > 0"
                    >
                        ต้นแบบสินค้า
                    </v-btn>

                    <v-btn
                        class="pink accent-2"
                        x-small
                        rounded
                        dark
                        v-if="item.add_ons.length > 0"
                    >
                        ตกแต่งเพิ่มเติม
                    </v-btn>

                    <v-btn class="indigo accent-3" x-small rounded dark>
                        ลูกบอล/ล้อม/ซ่อนเงิน
                    </v-btn>

                    <v-btn
                        class="cyan darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.a_order.order_delivery_service"
                    >
                        บริการจัดส่ง
                    </v-btn>

                    <v-btn
                        class="purple darken-3"
                        x-small
                        rounded
                        dark
                        v-if="item.is_take_a_photo"
                    >
                        ถ่ายรูปสินค้า
                    </v-btn>

                    <v-btn
                        class="lime darken-2"
                        x-small
                        rounded
                        dark
                        v-if="item.status_upload_images_from_customer"
                    >
                        รูปภาพลูกค้า
                    </v-btn>
                </div>
            </template> -->

            <template v-slot:item.manages="{ item }">
                <v-btn
                    class="info"
                    small
                    @click="clickToOrder(item.a_order.id)"
                >
                    <v-icon left>search</v-icon>
                    ดูข้อมูล
                </v-btn>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import imageThumbnailFullPathSizeFree from "@/js/components/google/drive/imageThumbnailFullPathSizeFree";
import btnPrototypeImage from "@/js/components/order/details/btnPrototypeImage.vue";
export default {
    props: ["propSearch"],
    components: { imageThumbnailFullPathSizeFree, btnPrototypeImage },
    data() {
        return {
            headers: [
                { text: "#", value: "a_order.id", width: "10%" },
                {
                    text: "เวลานัดรับ",
                    value: "a_order.time_get_format",
                    align: "center",
                    width: "10%",
                },
                {
                    text: "รูปภาพ",
                    value: "image_goods",
                    width: "5%",
                },
                {
                    text: "รายละเอียด",
                    value: "a_price.name_goods",
                },
                //{ text: "tags", value: "tags", width: "20%", align: "center" },
                {
                    text: "การจัดการ",
                    value: "manages",
                    align: "end",
                    width: "10%",
                },
            ],
        };
    },
    methods: {
        clickToOrder(id) {
            window.location.href = `/manages/order/${id}/showOrderByID`;
        },
    },
    computed: {
        ...mapGetters({
            details: "orderIndex/orders_details",
        }),
    },
};
</script>

<style></style>
