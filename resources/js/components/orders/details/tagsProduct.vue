<template>
    <div>
        {{ tag.product_category_sub_use_only.product_category.name }}
        :
        {{ tag.product_category_sub_use_only.name }}
    </div>
</template>

<script>
export default {
    props: ["tag"]
};
</script>

<style></style>
