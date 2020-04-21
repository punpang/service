<template>
    <v-img
        :src="'https://drive.google.com/thumbnail?id=' + src.src_name"
    ></v-img>
</template>

<script>
export default {
    props: ["src"]
};
</script>

<style></style>
