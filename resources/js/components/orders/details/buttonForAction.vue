<template>
    <div>
        <v-col cols="12" md="12" v-if="detail.status">
            <v-row>
                <formDetail
                    :detail="detail"
                    :action="action.update.detail"
                ></formDetail>
                <v-btn
                    color="primary"
                    v-if="detail.upload_image_status"
                    class="mr-2"
                >
                    <v-icon left>link</v-icon>
                    ส่งลิงก์อัปโหลดรูป
                </v-btn>
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

export default {
    props: ["detail"],
    components:{
        formDetail,deleteDetail
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
