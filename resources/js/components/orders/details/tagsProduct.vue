<template>
    <div>
        {{ tag.product_category_sub.product_category.name }}
        :
        {{ tag.product_category_sub.name }}
    </div>
</template>

<script>
export default {
    props: ["tag"]
};
</script>

<style></style>
