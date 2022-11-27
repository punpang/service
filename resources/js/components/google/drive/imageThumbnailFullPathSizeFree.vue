<template>
    <v-img
        :src="`https://drive.google.com/thumbnail?id=${path.google_image.src_name}&sz=w${size}-h${size}`"
        :lazy-src="`https://drive.google.com/thumbnail?id=${path.google_image.src_name}&sz=w${size}-h${size}`"
    >
        <v-btn v-if="propID" outlined class="deep-orange mt-3 ml-3 font-weight-bold" dark x-small
            >#{{ propID }}</v-btn
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
</template>

<script>
export default {
    props: ["path", "size", "propID"],
};
</script>

<style></style>
