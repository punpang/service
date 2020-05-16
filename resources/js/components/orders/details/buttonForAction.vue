<template>
    <div>
        <v-row v-if="detail.status" class="pa-2">
            <v-col cols="2" md="4" class="pa-1"
                ><formDetail
                    :detail="detail"
                    :action="action.update.detail"
                ></formDetail
            ></v-col>
            <v-col
                cols="2"
                md="4"
                class="pa-1"
                v-if="detail.upload_image_status"
                ><sentLinkMain :detail="detail"></sentLinkMain
            ></v-col>
            <v-col cols="2" md="4" class="pa-1"
                ><buttonFinishedProductImage
                    :detail="detail"
                ></buttonFinishedProductImage
            ></v-col>
            <v-col cols="2" md="4" class="pa-1"
                ><deleteDetail
                    :detail="detail"
                    :action="action.delete"
                ></deleteDetail
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
import buttonFinishedProductImage from "@/js/components/orders/details/buttonFinishedProductImage";

export default {
    props: ["detail"],
    components: {
        formDetail,
        deleteDetail,
        sentLinkMain,
        buttonFinishedProductImage
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
    }
};
</script>

<style></style>
