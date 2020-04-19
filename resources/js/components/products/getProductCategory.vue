<template>
    <div>
        <v-text-field
            label="ค้นหา"
            v-model="search"
            append-icon="search"
        ></v-text-field>
        <v-data-table
            :headers="headers"
            :items="this.$store.getters['productCategory/data']"
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
                >
                </v-switch>
            </template>

            <template v-slot:item.menu="{ item }">
                <div>
                    <editProductCategory :data="item"></editProductCategory>
                </div>
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
import editProductCategory from "@/js/components/products/editProductCategory";

export default {
    components: {
        editProductCategory
    },
    data() {
        return {
            overlay: false,
            search: "",
            snackbar:{
                status:false
            },
            headers: [
                { text: "ชื่อกลุ่ม", value: "name" },
                { text: "สถานะ", value: "status" },
                { text: "การจัดการ", value: "menu" }
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
            const response = await this.$store.dispatch(
                "productCategory/update",
                form
            );
            if (response.status == 200) {
                this.snackbar = {
                    status: true,
                    color: "success",
                    text: "เปลี่ยนแปลงสถานะสำเร็จ"
                };
                this.overlay = false;
            }
        }
    },
};
</script>

<style></style>
