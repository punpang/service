<template>
    <v-img
        :src="'https://drive.google.com/uc?id=' + path"
    ></v-img>
</template>

<script>
export default {
    props: ["path"]
};
</script>

<style></style>
