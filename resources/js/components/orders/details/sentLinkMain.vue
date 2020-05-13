<template>
    <div>
        <v-dialog v-model="dialog" persistent width="800">
            <template v-slot:activator="{ on }">
                <v-btn color="primary" class="mr-2 d-none d-sm-flex" v-on="on">
                    <v-icon left>link</v-icon>
                    ส่งลิงก์อัปโหลดรูป
                </v-btn>
                <v-btn
                    color="primary"
                    class="mr-2 d-flex d-sm-none"
                    fab
                    v-on="on"
                >
                    <v-icon left>link</v-icon>
                    <!-- ส่งลิงก์อัปโหลดรูป -->
                </v-btn>
            </template>
            <v-card>
                <v-card-title
                    >ส่งลิงก์อัปโหลดรูป
                    <v-spacer></v-spacer>
                    <v-icon color="error" @click="dialog = false">close</v-icon>
                </v-card-title>
                <v-card-text>
                    <sentLinkForUploadImage
                        :detail="detail"
                    ></sentLinkForUploadImage>
                </v-card-text>
            </v-card>
        </v-dialog>
       
    </div>
</template>

<script>
import sentLinkForUploadImage from "@/js/components/orders/details/sentLinkForUploadImage";
export default {
    props: ["detail"],
    components: {
        sentLinkForUploadImage
    },
    data() {
        return {
            dialog: false
        };
    }
};
</script>

<style></style>
