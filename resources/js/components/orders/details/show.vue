<template>
    <div>
        <v-card>
            <v-card-title>
                รายละเอียด
                <v-spacer></v-spacer>
                <v-icon @click="clickMenu">dehaze</v-icon>
            </v-card-title>
            <v-divider class="ma-1"></v-divider>
        </v-card>

        <v-card
            v-for="detail in details"
            :key="detail.id"            
            class="mt-4"
        >
            <v-card-title>
                {{ detail.product.name }}
            </v-card-title>
            <v-divider class="ma-0"></v-divider>
            <v-card-text >
                <v-container class="py-0">
                    <v-row>
                        <v-col cols="12" md="4">
                            <imageThumbnail
                                :src="detail.product.product_image"
                            ></imageThumbnail>
                        </v-col>
                        <v-col cols="12" md="8">
                            <p>ร่าคา {{ detail.price }}.00 บาท</p>
                            <p v-for="tag in detail.product.product_tag_use_only" :key="tag.id">
                                {{ tag.product_category_sub_use_only.product_category.name }} : {{ tag.product_category_sub_use_only.name }}
                            </p>
                        </v-col>
                    </v-row>
                </v-container>
                
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import imageThumbnail from "@/js/components/google/drive/imageThumbnail";
export default {
    props: ["order_id"],
    components: {
        imageThumbnail
    },
    data() {
        return {
            details: {}
        };
    },
    methods: {
        clickMenu() {
            this.$emit("emitClickMenu");
        }
    },
    async mounted() {
        await this.$store.dispatch("orderDetail/getByOrderID", this.order_id);
        this.details = await this.$store.getters["orderDetail/getByOrderId"];
        console.log(this.details);
    }
};
</script>

<style></style>
