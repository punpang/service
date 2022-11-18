<template>
    <div>
        {{ path[0] }}
        <!-- <v-img
        :src="'https://drive.google.com/thumbnail?id=' + path.google_image.src_name + '&sz=w200-h200'"
        :lazy-src="
            'https://drive.google.com/thumbnail?id=' + path.google_image.src_name + '&sz=w200-h200'
        "
    >
        <template v-slot:placeholder>
            <v-row class="fill-height ma-0" align="center" justify="center">
                <v-progress-circular
                    indeterminate
                    color="grey lighten-5"
                ></v-progress-circular>
            </v-row>
        </template>
    </v-img> -->
    </div>

</template>

<script>
export default {
    props: ["path"],
};
</script>

<style></style>
