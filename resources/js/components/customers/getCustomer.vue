<template>
    <div>
        <v-text-field
            v-model="search"
            label="ค้นหาลูกค้าจากหมายเลขโทรศัพท์"
            append-icon="search"
            type="number"
            pattern="/d*"
            @change="changeSearch(search)"
        ></v-text-field>
        <v-data-table
            :headers="headerTable"
            :items="this.$store.getters['customer/getCustomers']"
            :loading="loadingTable"
            :search="search"
            no-results-text="ไม่พบข้อมูลที่ค้นหา"
            loading-text="รอสักครู่...กำลังโหลดข้อมูล"
            item-key="id"
        >
            <template v-slot:item.action="{ item }">
                <v-container>
                    <v-row>
                        <editCustomer :data="item" class="mr-2"></editCustomer>
                        <deleteCustomer
                            :data="item"
                            class="mr-2"
                        ></deleteCustomer>
                        <v-btn
                            v-if="selectCustomerInGet == true"
                            fab
                            x-small
                            color="info"
                            @click="clickSelectCustomer(item)"
                        >
                            <v-icon>get_app</v-icon>
                        </v-btn>
                    </v-row>
                </v-container>
            </template>
        </v-data-table>
        <v-snackbar v-model="snackbar.status" right :color="snackbar.color">{{
            snackbar.text
        }}</v-snackbar>
    </div>
</template>

<script>
import editCustomer from "@/js/components/customers/edit";
import deleteCustomer from "@/js/components/customers/delete";

export default {
    props: ["selectCustomerInGet"],
    components: {
        editCustomer,
        deleteCustomer
    },
    data() {
        return {
            loadingTable: true,
            search: "",
            headerTable: [
                { text: "ชื่อลูกค้า", value: "name" },
                { text: "เบอร์โทร", value: "phone" },
                { text: "การจัดการ", value: "action" }
            ],
            snackbar: {
                status: true,
                color: "info",
                text: "กำลังโหลดข้อมูล..."
            }
        };
    },
    methods: {
        remove() {
            confirm("คุณต้องการลบใช่หรือไม่");
        },
        clickSelectCustomer(value) {
            this.$emit("onCustomer", value);
        },
        changeSearch(search) {
            this.$emit("onSearch", search);
            
        }
    },
    async beforeCreate() {
        const response = await this.$store.dispatch("customer/get");
        if (response.status === 200) {
            this.loadingTable = false;
            this.snackbar = {
                status: true,
                color: "success",
                text: "โหลดข้อมูลลูกค้าสำเร็จ"
            };
        } else {
            this.snackbar = {
                status: true,
                color: "warning",
                text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองอีกครั้ง"
            };
            this.loadingTable = false;
        }
    }
};
</script>

<style></style>
