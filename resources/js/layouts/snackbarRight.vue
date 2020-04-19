<template>
    <v-snackbar v-model="snackbar.status" :color="snackbar.color" right>{{
        snackbar.text
    }}</v-snackbar>
</template>

<script>
export default {
    props: ["snackbar"]
};
</script>

<style></style>
