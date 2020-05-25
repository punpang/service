<template>
    <div>
        <v-row v-if="detail.status" class="pa-2">
            <v-col cols="2" md="4" class="pa-1" v-if="status()"
                ><formDetail
                    :detail="detail"
                    :action="action.update.detail"
                ></formDetail
            ></v-col>
            <v-col v-if="status() && detail.hide_money" cols="2" md="4" class="pa-1">
                <hideMoney></hideMoney>
            </v-col>
            <v-col
                v-if="status() && detail.upload_image_status"
                cols="2"
                md="4"
                class="pa-1"
                ><sentLinkMain :detail="detail"></sentLinkMain
            ></v-col>
            <v-col cols="2" md="4" class="pa-1" v-if="status()"
                ><deleteDetail
                    :detail="detail"
                    :action="action.delete"
                ></deleteDetail
            ></v-col>
            <v-col cols="2" md="4" class="pa-1" v-if="!status()"
                ><buttonFinishedProductImage
                    :detail="detail"
                ></buttonFinishedProductImage
            ></v-col>

            <!---
            <formDetail
                :detail="detail"
                :action="action.update.detail"
            ></formDetail>
            <sentLinkMain
                v-if="detail.upload_image_status"
                :detail="detail"
            ></sentLinkMain>
            <buttonFinishedProductImage
                class="mr-2"
                :detail="detail"
            ></buttonFinishedProductImage>
            <deleteDetail
                :detail="detail"
                :action="action.delete"
            ></deleteDetail>
            -->
        </v-row>

        <v-row v-else>
            <v-col cols="2" md="4" class="pa-1"
                ><deleteDetail
                    :detail="detail"
                    :action="action.redelete"
                ></deleteDetail
            ></v-col>
        </v-row>
    </div>
</template>

<script>
import formDetail from "@/js/components/orders/details/_form_detail";
import deleteDetail from "@/js/components/orders/details/deleteDetail";
import sentLinkMain from "@/js/components/orders/details/sentLinkMain";
import hideMoney from "@/js/components/orders/details/hideMoney";
import buttonFinishedProductImage from "@/js/components/orders/details/buttonFinishedProductImage";

export default {
    props: ["detail"],
    components: {
        formDetail,
        deleteDetail,
        sentLinkMain,
        buttonFinishedProductImage,
        hideMoney
    },
    data() {
        return {
            action: {
                update: {
                    detail: {
                        method: "update",
                        title: "แก้ไขสินค้า",
                        icon: "edit"
                    }
                },
                delete: {
                    method: "delete",
                    buttonHead: {
                        icon: "cancel",
                        color: "error",
                        text: "ยกเลิกสินค้า"
                    }
                },
                redelete: {
                    method: "redelete",
                    buttonHead: {
                        color: "info",
                        icon: "refresh",
                        text: "เรียกคืนสินค้า"
                    }
                }
            }
        };
    },
    methods: {
        status() {
            const s = this.$store.getters["order/getByID"].data.order_status_id;
            if (s >= 2 && s <= 5) {
                return true;
            } else {
                return false;
            }
        }
    }
};
</script>

<style></style>
