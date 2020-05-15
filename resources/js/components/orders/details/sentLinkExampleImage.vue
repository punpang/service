<template>
    <v-dialog v-model="dialog" persistent width="400">
        <template v-slot:activator="{ on }">
            <v-btn color="teal" v-on="on">
                รูปต้นแบบสินค้า
            </v-btn>
        </template>
        <v-img
            :src="detail.upload_image.example_image.url"
            :lazy-src="detail.upload_image.example_image.url"
        >
            <v-btn color="error" fab large class="ma-4" @click="dialog = false"
                ><v-icon>close</v-icon></v-btn
            >

            <template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular
                        indeterminate
                        color="grey lighten-5"
                    ></v-progress-circular>
                </v-row>
            </template>
        </v-img>
    </v-dialog>
</template>

<script>
export default {
    props: ["detail"],
    data() {
        return {
            dialog: false
        };
    }
};
</script>

<style></style>
