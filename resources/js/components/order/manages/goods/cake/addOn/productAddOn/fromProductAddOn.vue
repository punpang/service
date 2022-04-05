<template>
    <div>
        <v-card-text>
            <v-autocomplete
                clearable
                outlined
                label="ชื่อสินค้า"
                v-model="goods_add_on"
                :items="goods_add_ons"
                item-text="name"
                item-value="id"
                hide-details
                @change="changeFetchProductAddOn()"
            ></v-autocomplete>
            <v-autocomplete
                class="my-3"
                clearable
                outlined
                label="ขนาดสินค้า"
                v-model="m4"
                :items="am_4s"
                item-text="m4"
                item-value="id"
                hide-details
                @change="changeFetchProductAddOn()"
            ></v-autocomplete>
            <v-text-field
                label="ราคา"
                suffix="บาท"
                outlined
                hide-details
                type="number"
                pattern="\d*"
                v-model="price"
            ></v-text-field>
        </v-card-text>
        <v-card-actions>
            <v-btn class="info mr-2" @click="start()" >
                <v-icon left>refresh</v-icon>
                โหลดใหม่</v-btn
            >
            <btnGoodsAddOn></btnGoodsAddOn>
            <v-spacer></v-spacer>
            <!-- <v-btn
                class="warning"
                @click="reset()"
                :disabled="propAddOn != null"
            >
                <v-icon left>autorenew</v-icon>
                เริ่มใหม่</v-btn
            > -->
            <v-btn class="success" @click="save()">
                <v-icon left>save</v-icon>
                บันทึก</v-btn
            >
        </v-card-actions>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
import btnGoodsAddOn from "@/js/components/order/manages/goods/cake/addOn/goodsAddOn/btnGoodsAddOn";
export default {
    props: ["propAddOn"],
    components: { btnGoodsAddOn },
    data() {
        return {
            goods_add_on: "",
            m4: "",
            price: "",
        };
    },
    methods: {
        async save() {
            let loader = this.$loading.show();
            const payload = {
                goods_add_on: {
                    id: this.goods_add_on,
                },
                m4: this.m4,
                price: this.price,
            };
            await this.$store.dispatch(
                "orderProductAddOn/updateOrCreate",
                payload
            );
            this.$toast.success("เรียบร้อย");
            loader.hide();

            if (this.propAddOn != null) {
                this.propAddOn.price = this.price;
                return;
            }

            this.reset();
        },
        async changeFetchProductAddOn() {
            if (this.goods_add_on != "" && this.m4 != "") {
                let loader = this.$loading.show();
                const payload = {
                    isFirst: true,
                    goods_add_on_id: this.goods_add_on,
                    am4_id: this.m4,
                };
                await this.$store.dispatch("orderProductAddOn/fetch", payload);
                this.price = this.product_add_on.price;
                loader.hide();
            }
        },
        async fetchGoodsAddOns() {
            let loader = this.$loading.show();
            const payload = {};
            await this.$store.dispatch("orderGoodsAddOn/fetch", payload);
            loader.hide();
        },
        async fetchAM4s() {
            let loader = this.$loading.show();
            const payload = {};
            await this.$store.dispatch("orderM4/fetch", payload);
            loader.hide();
        },
        async start() {
            await this.fetchGoodsAddOns();
            await this.fetchAM4s();
        },
        reset() {
            this.goods_add_on = "";
            this.m4 = "";
            this.price = "";
        },
    },
    async mounted() {
        await this.start();
        if (this.propAddOn != null) {
            this.goods_add_on = this.propAddOn.goods_add_on_id;
            this.m4 = this.propAddOn.am4_id;
            this.changeFetchProductAddOn();
        }
    },

    computed: {
        ...mapGetters({
            goods_add_ons: "orderGoodsAddOn/fetch",
            am_4s: "orderM4/fetch",
            product_add_on: "orderProductAddOn/fetch",
        }),
    },
};
</script>
