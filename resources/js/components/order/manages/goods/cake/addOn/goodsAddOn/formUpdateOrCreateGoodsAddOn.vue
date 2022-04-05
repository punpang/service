<template>
    <div>
        <v-text-field
            outlined
            label="ชื่อสินค้าเพิ่มเติม"
            hide-details
            v-model="name"
        ></v-text-field>
        <v-card-actions class="pt-2 px-0 pb-0">
            <v-spacer></v-spacer>

            <v-btn class="success" @click="save()" :disabled="name == ''">
                <v-icon left>save</v-icon>
                บันทึก
            </v-btn>
        </v-card-actions>
    </div>
</template>

<script>
export default {
    props: ["propGoodsAddOn"],
    data() {
        return { name: "" };
    },
    methods: {
        async save() {
            let loader = this.$loading.show();
            const payload = {
                name: this.name,
                goods_add_on: this.propGoodsAddOn,
            };

            const result = await this.$store.dispatch(
                "orderGoodsAddOn/updateOrCreate",
                payload
            );

            if (result.status === 200) {
                this.$toast.success("บันทึกเรียบร้อย");
                if (this.propGoodsAddOn != null) {
                    this.propGoodsAddOn.name = this.name;
                } else {
                    this.$store.commit(
                        "orderGoodsAddOn/pushFetch",
                        result.data.data
                    );
                }
            } else {
                this.$toast.error("มีข้อผิดพลาดบางประการ");
            }

            loader.hide();
        },
    },
    mounted() {
        if (this.propGoodsAddOn != null) {
            this.name = this.propGoodsAddOn.name;
        }
    },
};
</script>
