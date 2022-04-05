<template>
    <div>
        <v-dialog persistent width="400" v-model="dialog" scrollable>
            <template v-slot:activator="{ on }">
                <v-btn class="white" elevation="0" v-on="on" @click="start()">
                    <v-icon left>delete</v-icon>
                    <div class="d-none d-sm-flex">ลบสินค้า</div>
                </v-btn>
            </template>
        </v-dialog>
    </div>
</template>

<script>
export default {
    props: ["propDetailTemp"],
    data() {
        return {
            dialog: false,
        };
    },
    methods: {
        start() {
            this.$swal({
                title: "ลบรายการสินค้า",
                text: `คุณต้องการลบสินค้า ${this.propDetailTemp.temp.a_price.name_goods} ใช่หรือไม่`,
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
            const payload = {
                order_detail_temp: this.propDetailTemp,
            };

            await this.$store.dispatch("orderDetailTemp/delete", payload);
            loader.hide();
            this.$toast.success("ลบรายการสำเร็จ");
            this.dialog = false;
        },
    },
};
</script>
