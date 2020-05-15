<template>
    <div>
        <v-col cols="12" md="12" v-if="detail.status">
            <v-row>
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
            </v-row>
        </v-col>

        <v-col cols="12" md="12" v-else>
            <v-row>
                <deleteDetail
                    :detail="detail"
                    :action="action.redelete"
                ></deleteDetail>
            </v-row>
        </v-col>
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
