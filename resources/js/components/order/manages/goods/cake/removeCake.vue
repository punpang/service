<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-list-item v-on="on" @click="start()">
                    <v-list-item-icon>
                        <v-icon color="error">delete</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content class="p-0">
                        <v-list-item-title class="red--text py-2"
                            >ลบสินค้า</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>

                <!-- <v-btn
                    class="white red--text"
                    elevation="0"
                    v-on="on"
                    @click="start()"
                    :block="propBlock"
                >
                    <v-icon left color="error">delete</v-icon>
                    <div class="d-none d-sm-flex">ลบสินค้า</div>
                </v-btn> -->
            </template>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["propOrderDetail", "propBlock"],
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        start() {
            this.$swal({
                title: "ลบรายการสินค้า",
                text: `คุณต้องการลบสินค้า ${this.propOrderDetail.a_price.name_goods} ใช่หรือไม่`,
                icon: "error",
                allowOutsideClick: false,
                confirmButtonText: `ใช่ (ลบ)`,
                denyButtonText: "ไม่ใช่ (ไม่ลบ)",
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.remove();
                } else if (result.isDenied) {
                    this.dialog = false;
                }
            });
        },
        async remove() {
            let loader = this.$loading.show();
            const payload = this.propOrderDetail;
            await this.$store.dispatch("orderIndex/orderDetailDelete", payload);
            loader.hide();
            this.$toast.success("ลบรายการสำเร็จ");
            this.dialog = false;
        },
    },
};
</script>
