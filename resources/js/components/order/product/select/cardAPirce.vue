<template>
    <div v-if="propAPrice.id != null" class="mb-2">
        <div class="text-subtitle-2 font-weight-bold">ชื่อสินค้า</div>
        <div class="pl-2">
            {{ propAPrice.name_goods }}
        </div>
        <div class="text-subtitle-2 font-weight-bold">
            ราคา {{ propAPrice.price }} บาท
        </div>
    </div>
</template>

<script>
export default {
    props: ["propAPrice"],
};
</script>
