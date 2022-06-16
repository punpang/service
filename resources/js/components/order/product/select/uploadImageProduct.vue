<template>
    <div>
        <uploadImageMultiple
            :propUploadImange="image"
            @emitImagesId="emitImagesId"
            class="mb-3"
            v-if="product.google_image == null || propISRemove"
        ></uploadImageMultiple>
        <imageThumbnailPathSize800
            v-else
            :path="product.google_image.src_name"
        ></imageThumbnailPathSize800>
    </div>
</template>

<script>
import uploadImageMultiple from "@/js/components/google/drive/uploadImageMultiple";
import imageThumbnailPathSize800 from "@/js/components/google/drive/imageThumbnailPathSize800";
import { mapGetters } from "vuex";
export default {
    props: ["propISRemove"],
    components: {
        uploadImageMultiple,
        imageThumbnailPathSize800,
    },
    data() {
        return {
            image: {},
        };
    },
    methods: {
        async emitImagesId(v) {
            let loader = this.$loading.show();
            const payload = {
                product_id: this.product.id,
                images: v,
            };

            const result = await this.$store.dispatch(
                "orderProductCake/uploadImageProduct",
                payload
            );
            this.$emit("emitSuccessUploadImageProduct");
            loader.hide();
        },
        clickRemoveImage() {},
    },
    computed: {
        ...mapGetters({
            product: "orderProductCake/fetchProduct",
        }),
    },
};
</script>
