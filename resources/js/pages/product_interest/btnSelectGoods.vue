<template>
    <div>
        <v-btn icon fab x-small @click="addGoods">
            <v-icon color="info">file_download</v-icon>
        </v-btn>
    </div>
</template>

<script>
export default {
    props: ["propGoods"],
    components: {},
    data() {
        return {};
    },
    methods: {
        addGoods() {
            this.$emit("emitAddGoodsProductInterest", this.propGoods);
        },
    },
};
</script>

<style></style>
