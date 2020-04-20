<template>
    <div>
        {{
            setPrice(
                price.price_normal,
                price.price_special,
                price.price_special_status
            )
        }}
    </div>
</template>

<script>
export default {
    props: ["price"],
    data() {
        return {
            priceProduct: 0
        };
    },
    methods: {
        setPrice(n, s, st) {
            if (st == 0) {
                this.priceProduct = n;
            } else {
                this.priceProduct = s;
            }
            return "ราคา " + this.priceProduct + ".00 บาท";
        }
    }
};
</script>

<style></style>
