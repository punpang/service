<template>
    <div>
        {{Processing(product)}}
    </div>
</template>

<script>
export default {
    props: ["product"],
    data() {
        return {
            priceProduct: 0
        };
    },
    methods: {
        Processing(product) {
            // ราคา product.price_normal,product.price_special,product.price_special_status
            if (product.price_special_status == 0) {
                this.priceProduct = product.price_normal;
            } else {
                this.priceProduct = product.price_special;
            }

            const processed = {
                price : this.priceProduct
            }
        
            this.$emit('emitProcessed',processed)
        }
    }
};
</script>

<style></style>
