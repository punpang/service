<template>
    <div>
        <v-text-field
            label="ค้นหา"
            v-model="search"
            append-icon="search"
        ></v-text-field>
        <v-data-table
            :headers="headers"
            :items="this.$store.getters['product/data']"
            :loading="loadingTable"
            :search="search"
            :items-per-page="10"
            no-results-text="ไม่พบข้อมูลที่ค้นหา"
            loading-text="รอสักครู่...กำลังโหลดข้อมูล"
            item-key="id"
        >
            <template v-slot:item.status="{ item }">
                <v-switch
                    v-model="item.status"
                    inset
                    @change="changeStatus(item)"
                ></v-switch>
            </template>

            <template v-slot:item.price_normal="{ item }">
                <v-row>
                    <v-col v-if="item.price_special_status == true"
                        ><p>
                            <S class="red--text">{{ item.price_normal }}</S> /
                            {{ item.price_special }}
                        </p></v-col
                    >
                    <v-col v-else
                        ><p>
                            {{ item.price_normal }} /
                            <S class="red--text">ไม่มี</S>
                        </p></v-col
                    >
                </v-row>
            </template>

            <template v-slot:item.product_image_id="{ item }">
                <v-img
                    v-show="item.image_status == true"
                    width="100"
                    :src="'https://drive.google.com/thumbnail?id=' + item.product_image.src_name"
                ></v-img>
            </template>

            <template v-slot:item.action="{ item }">
                <v-container>
                    <v-row>
                        <ProductUpdate
                            :data="item"
                            class="mr-2"
                        ></ProductUpdate>
                        <ProductTagMain
                            :data="item"
                            class="mr-2"
                        ></ProductTagMain>
                    </v-row>
                </v-container>
            </template>
        </v-data-table>
        <v-snackbar v-model="snackbar.status" :color="snackbar.color" right>{{
            snackbar.text
        }}</v-snackbar>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate :size="this.$store.getters['main/sizeOverlay']"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
import ProductUpdate from "@/js/components/products/ProductEdit";
import ProductTagMain from "@/js/components/products/ProductTagMain";

export default {
    components: {
        ProductUpdate,
        ProductTagMain
    },
    data() {
        return {
            snackbar: {
                status: false
            },
            overlay: true,
            search: "",
            loadingTable: true,
            headers: [
                { text: "รูปสินค้า", value: "product_image_id" },
                { text: "ชื่อสินค้า", value: "name" },
                { text: "ราคาปกติ/ราคาพิเศษ", value: "price_normal" },
                { text: "สถานะ", value: "status" },
                { text: "การจัดการ", value: "action" }
            ]
        };
    },
    methods: {
        async changeStatus(data) {
            this.overlay = true;
            const form = {
                id: data.id,
                status: data.status
            };
            const response = await this.$store.dispatch("product/update", form);
            if (response.status == 200) {
                this.snackbar = {
                    status: true,
                    text: "เปลี่ยนแปลงสถานะเรียบร้อย",
                    color: "success"
                };
                this.overlay = false;
            } else {
                this.snackbar = {
                    status: true,
                    text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่ภายหลัง",
                    color: "error"
                };
                this.overlay = false;
            }
        }
    },
    async beforeCreate() {
        await this.$store.dispatch("product/get");
        this.loadingTable = false;
        this.overlay = false;
    }
};
</script>

<style></style>
